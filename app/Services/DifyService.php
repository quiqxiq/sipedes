<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DifyService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected ?string $knowledgeApiKey;
    protected ?string $datasetId;

    /** Cache hasil parsing .env agar tidak dibaca ulang setiap instansiasi. */
    protected static ?array $envCache = null;

    public function __construct()
    {
        // Di Windows, environment variable sistem dapat menimpa nilai .env (Laravel
        // tidak menimpa env yang sudah ada). Prioritaskan nilai langsung dari file
        // .env agar kredensial Dify selalu yang benar meski env sistem sudah kedaluwarsa.
        $env = $this->readEnvFile();

        $this->baseUrl = rtrim(
            (string) ($env['DIFY_BASE_URL'] ?? config('services.dify.base_url', 'http://localhost/v1')),
            '/'
        );
        $this->apiKey = (string) ($env['DIFY_API_KEY'] ?? config('services.dify.api_key', env('DIFY_API_KEY')));
        $this->knowledgeApiKey = $env['DIFY_KNOWLEDGE_API_KEY'] ?? config('services.dify.knowledge_api_key', env('DIFY_KNOWLEDGE_API_KEY'));
        $this->datasetId = $env['DIFY_DATASET_ID'] ?? config('services.dify.dataset_id', env('DIFY_DATASET_ID'));
    }

    /**
     * Baca pasangan KEY=value dari file .env (sederhana, tanpa dependensi tambahan).
     *
     * @return array<string, string>
     */
    protected function readEnvFile(): array
    {
        if (static::$envCache !== null) {
            return static::$envCache;
        }

        $path = base_path('.env');

        if (! is_file($path)) {
            return static::$envCache = [];
        }

        $values = [];

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#') || str_starts_with($line, 'export ')) {
                continue;
            }

            // Buang komentar inline (mis. KEY=value # catatan), kecuali di dalam tanda kutip.
            $line = preg_replace('/\s+#.*$/', '', $line);

            [$key, $value] = array_pad(explode('=', $line, 2), 2, '');
            $values[trim($key)] = trim($value, " \t\"'");
        }

        return static::$envCache = $values;
    }

    public function isConfigured(): bool
    {
        return filled($this->apiKey) && filled($this->knowledgeApiKey) && filled($this->datasetId);
    }

    public function isKnowledgeConfigured(): bool
    {
        return filled($this->knowledgeApiKey) && filled($this->datasetId);
    }

    /**
     * Kirim pertanyaan ke Chatbot Dify (Blocking Mode).
     *
     * @return array{success: bool, answer?: string, conversation_id?: ?string, message_id?: ?string, sources?: array, message?: string}
     */
    public function sendMessage(string $query, ?string $conversationId = null, string $userId = 'guest'): array
    {
        if (blank($this->apiKey)) {
            return $this->error('DIFY_API_KEY belum dikonfigurasi di file .env.');
        }

        try {
            $response = Http::withToken($this->apiKey)
                ->acceptJson()
                ->timeout(60)
                ->post("{$this->baseUrl}/chat-messages", [
                    'inputs' => new \stdClass(),
                    'query' => $query,
                    'response_mode' => 'blocking',
                    'conversation_id' => $conversationId ?: '',
                    'user' => (string) $userId,
                    'files' => [],
                ]);

            if ($response->failed()) {
                Log::channel('single')->error('Dify Chat API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return $this->error(
                    'Dify tidak merespons dengan baik (' . $response->status() . '): ' . $this->extractErrorMessage($response)
                );
            }

            $data = $response->json();

            return [
                'success' => true,
                'answer' => $data['answer'] ?? '',
                'conversation_id' => $data['conversation_id'] ?? null,
                'message_id' => $data['message_id'] ?? null,
                'sources' => $data['metadata']['retriever_resources'] ?? [],
            ];
        } catch (Exception $e) {
            Log::channel('single')->error('Dify Chat Exception: ' . $e->getMessage());

            return $this->error('Gagal terhubung ke server Dify: ' . $e->getMessage());
        }
    }

    /**
     * Kirim pertanyaan ke Chatbot Dify dalam mode STREAMING (SSE).
     *
     * Menghasilkan jawaban secara bertahap; setiap potongan jawaban diteruskan
     * ke callback $onChunk sehingga UI dapat menampilkan teks real-time
     * (jauh lebih cepat terasa daripada blocking mode).
     *
     * @param  callable(string):void  $onChunk
     * @return array{success: bool, answer?: string, conversation_id?: ?string, message_id?: ?string, sources?: array, message?: string}
     */
    public function streamMessage(string $query, callable $onChunk, ?string $conversationId = null, string $userId = 'guest'): array
    {
        if (blank($this->apiKey)) {
            return $this->error('DIFY_API_KEY belum dikonfigurasi di file .env.');
        }

        // Streaming bisa berlangsung lama (beberapa puluh detik) — jangan biarkan PHP memotongnya.
        set_time_limit(0);

        try {
            $response = Http::withToken($this->apiKey)
                ->acceptJson()
                ->withOptions([
                    'stream' => true,
                    'read_timeout' => 300,
                ])
                ->timeout(300)
                ->post("{$this->baseUrl}/chat-messages", [
                    'inputs' => new \stdClass(),
                    'query' => $query,
                    'response_mode' => 'streaming',
                    'conversation_id' => $conversationId ?: '',
                    'user' => (string) $userId,
                    'files' => [],
                ]);

            if ($response->failed()) {
                Log::channel('single')->error('Dify Chat Stream Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return $this->error(
                    'Dify tidak merespons dengan baik (' . $response->status() . '): ' . $this->extractErrorMessage($response)
                );
            }

            $body = $response->toPsrResponse()->getBody();

            $buffer = '';
            $eventData = [];
            $answer = '';
            $streamConversationId = $conversationId;
            $messageId = null;
            $sources = [];
            // Chatflow mengirim jawaban sebagai DELTA; Chat App mengirim versi kumulatif.
            // Ditentukan dari field "mode" pada event message.
            $deltaAnswer = true;

            while (! $body->eof()) {
                $chunk = $body->read(8192);

                if ($chunk === '') {
                    usleep(50000);
                    continue;
                }

                $buffer .= $chunk;

                // SSE dipisahkan per baris; sebuah event selesai saat bertemu baris kosong.
                while (($pos = strpos($buffer, "\n")) !== false) {
                    $line = substr($buffer, 0, $pos);
                    $buffer = substr($buffer, $pos + 1);
                    $trimmed = trim($line);

                    if ($trimmed === '') {
                        // Akhir event SSE — proses semua baris data yang terkumpul.
                        if ($eventData !== []) {
                            $this->consumeStreamEvent(
                                $eventData,
                                $onChunk,
                                $answer,
                                $streamConversationId,
                                $messageId,
                                $sources,
                                $deltaAnswer
                            );
                            $eventData = [];
                        }
                        continue;
                    }

                    if (str_starts_with($trimmed, 'data:')) {
                        $eventData[] = trim(substr($trimmed, 5));
                    }
                }
            }

            // Event terakhir tanpa baris kosong penutup.
            if ($eventData !== []) {
                $this->consumeStreamEvent(
                    $eventData,
                    $onChunk,
                    $answer,
                    $streamConversationId,
                    $messageId,
                    $sources,
                    $deltaAnswer
                );
            }

            return [
                'success' => true,
                'answer' => $answer,
                'conversation_id' => $streamConversationId,
                'message_id' => $messageId,
                'sources' => $sources,
            ];
        } catch (Exception $e) {
            // Tutup body stream jika masih terbuka agar tidak membocorkan resource.
            if (isset($body)) {
                $body->close();
            }
            Log::channel('single')->error('Dify Chat Stream Exception: ' . $e->getMessage());

            return $this->error('Gagal terhubung ke server Dify: ' . $e->getMessage());
        }
    }

    /**
     * Proses satu event SSE dari Dify: update jawaban, conversation id, dan sumber dokumen.
     *
     * @param  array       $eventData      Baris-baris payload (setelah prefix "data:")
     * @param  callable    $onChunk        Callback streaming jawaban
     * @param  string      $answer         Akumulator jawaban (by reference)
     * @param  string|null $conversationId Akumulator conversation id (by reference)
     * @param  string|null $messageId      Akumulator message id (by reference)
     * @param  array       $sources        Akumulator sumber dokumen (by reference)
     */
    protected function consumeStreamEvent(array $eventData, callable $onChunk, string &$answer, ?string &$conversationId, ?string &$messageId, array &$sources, bool &$deltaAnswer): void
    {
        $payload = implode("\n", $eventData);
        $data = json_decode($payload, true);

        if (! is_array($data)) {
            Log::channel('single')->warning('Dify SSE event tidak valid JSON: ' . Str::limit($payload, 200));

            return;
        }

        $event = $data['event'] ?? 'message';

        if ($event === 'message' && isset($data['answer']) && is_string($data['answer'])) {
            // Chatflow (mode "workflow") mengirim jawaban sebagai DELTA (potongan baru per
            // event), jadi akumulasikan. Chat App biasa (mode lain) mengirim versi kumulatif,
            // jadi timpa langsung agar teks tidak berlipat ganda.
            if (isset($data['mode'])) {
                $deltaAnswer = $data['mode'] === 'workflow';
            }

            $answer = $deltaAnswer ? $answer . $data['answer'] : $data['answer'];
            $onChunk($answer);
        }

        if (! empty($data['conversation_id'])) {
            $conversationId = $data['conversation_id'];
        }

        if (! empty($data['message_id'])) {
            $messageId = $data['message_id'];
        }

        // Chat App biasa mengirim sumber di message_end; Chatflow tidak (kosong),
        // jadi jangan timpa sumber yang sudah terisi dari node Knowledge Retrieval.
        if ($event === 'message_end' && ! empty($data['metadata']['retriever_resources'])) {
            $sources = $data['metadata']['retriever_resources'];
        }

        // Chatflow: ambil sumber dokumen dari hasil node Knowledge Retrieval.
        if ($event === 'node_finished'
            && ($data['data']['node_type'] ?? '') === 'knowledge-retrieval'
            && isset($data['data']['outputs']['result'])
        ) {
            $retrieved = $data['data']['outputs']['result'];
            $seen = [];

            foreach ($retrieved as $item) {
                $documentName = $item['metadata']['document_name']
                    ?? $item['title']
                    ?? 'Dokumen Desa';

                // Beberapa segmen bisa berasal dari dokumen yang sama — jangan tampilkan duplikat.
                if (in_array($documentName, $seen, true)) {
                    continue;
                }

                $seen[] = $documentName;

                $sources[] = [
                    'document_name' => (string) $documentName,
                    'score' => $item['metadata']['score'] ?? null,
                ];
            }
        }

        if ($event === 'error') {
            throw new Exception('Dify mengembalikan error saat streaming: ' . ($data['message'] ?? 'unknown error'));
        }
    }

    /**
     * Daftar dataset (knowledge base) yang dapat diakses API key dataset.
     *
     * @return array{success: bool, datasets?: array, message?: string}
     */
    public function getDatasets(): array
    {
        try {
            $response = Http::withToken($this->knowledgeApiKey)
                ->acceptJson()
                ->timeout(15)
                ->get("{$this->baseUrl}/datasets", [
                    'page' => 1,
                    'limit' => 50,
                ]);

            if ($response->failed()) {
                return $this->error('Gagal mengambil daftar dataset (' . $response->status() . '): ' . $this->extractErrorMessage($response));
            }

            return [
                'success' => true,
                'datasets' => $response->json('data', []),
            ];
        } catch (Exception $e) {
            Log::channel('single')->error('Dify GetDatasets Exception: ' . $e->getMessage());

            return $this->error($e->getMessage());
        }
    }

    /**
     * Buat dataset (knowledge base) baru di Dify.
     *
     * @return array{success: bool, dataset_id?: ?string, message?: string}
     */
    public function createDataset(string $name, string $description = '', string $indexingTechnique = 'economy'): array
    {
        try {
            $response = Http::withToken($this->knowledgeApiKey)
                ->acceptJson()
                ->timeout(20)
                ->post("{$this->baseUrl}/datasets", [
                    'name' => $name,
                    'description' => $description,
                    'indexing_technique' => $indexingTechnique,
                    'permission' => 'only_me',
                ]);

            if ($response->failed()) {
                return $this->error('Gagal membuat dataset (' . $response->status() . '): ' . $this->extractErrorMessage($response));
            }

            return [
                'success' => true,
                'dataset_id' => $response->json('id'),
            ];
        } catch (Exception $e) {
            Log::channel('single')->error('Dify CreateDataset Exception: ' . $e->getMessage());

            return $this->error($e->getMessage());
        }
    }

    /**
     * Upload & indeks dokumen ke Dify Knowledge Base (create-by-file).
     *
     * @return array{success: bool, document_id?: ?string, indexing_status?: ?string, message?: string}
     */
    public function uploadDocument(string $filePath, string $fileName): array
    {
        if (! $this->isKnowledgeConfigured()) {
            return $this->error('DIFY_KNOWLEDGE_API_KEY atau DIFY_DATASET_ID belum dikonfigurasi di file .env.');
        }

        if (! is_file($filePath)) {
            return $this->error("File tidak ditemukan di storage: {$filePath}");
        }

        try {
            // Economy = tanpa embedding model; aman untuk self-hosted Dify tanpa model embedding.
            // Ganti ke 'high_quality' jika embedding model sudah dikonfigurasi di Dify.
            $data = json_encode([
                'indexing_technique' => 'economy',
                'process_rule' => [
                    'mode' => 'automatic',
                ],
            ], JSON_UNESCAPED_SLASHES);

            $response = Http::withToken($this->knowledgeApiKey)
                ->timeout(120)
                ->attach('file', fopen($filePath, 'r'), $fileName)
                ->post("{$this->baseUrl}/datasets/{$this->datasetId}/document/create-by-file", [
                    'data' => $data,
                ]);

            if ($response->failed()) {
                Log::channel('single')->error('Dify Upload Document Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return $this->error('Gagal mengunggah dokumen ke Dify (' . $response->status() . '): ' . $this->extractErrorMessage($response));
            }

            $data = $response->json();

            return [
                'success' => true,
                'document_id' => $data['document']['id'] ?? null,
                'indexing_status' => $data['document']['indexing_status'] ?? 'indexing',
            ];
        } catch (Exception $e) {
            Log::channel('single')->error('Dify Upload Exception: ' . $e->getMessage());

            return $this->error('Gagal mengunggah dokumen ke Dify: ' . $e->getMessage());
        }
    }

    /**
     * Daftar dokumen yang ada di dataset.
     *
     * @return array{success: bool, documents?: array, message?: string}
     */
    public function getDocuments(): array
    {
        if (! $this->isKnowledgeConfigured()) {
            return $this->error('DIFY_KNOWLEDGE_API_KEY atau DIFY_DATASET_ID belum dikonfigurasi.');
        }

        try {
            $response = Http::withToken($this->knowledgeApiKey)
                ->acceptJson()
                ->timeout(15)
                ->get("{$this->baseUrl}/datasets/{$this->datasetId}/documents", [
                    'page' => 1,
                    'limit' => 100,
                ]);

            if ($response->failed()) {
                return $this->error('Gagal mengambil daftar dokumen (' . $response->status() . '): ' . $this->extractErrorMessage($response));
            }

            return [
                'success' => true,
                'documents' => $response->json('data', []),
            ];
        } catch (Exception $e) {
            Log::channel('single')->error('Dify GetDocuments Exception: ' . $e->getMessage());

            return $this->error($e->getMessage());
        }
    }

    /**
     * Cek status indexing dokumen di Dify.
     *
     * @return array{success: bool, status?: ?string, completed_segments?: ?int, total_segments?: ?int, message?: string}
     */
    public function getIndexingStatus(string $difyDocumentId): array
    {
        if (! $this->isKnowledgeConfigured()) {
            return $this->error('DIFY_KNOWLEDGE_API_KEY atau DIFY_DATASET_ID belum dikonfigurasi.');
        }

        // Coba endpoint khusus per-dokumen terlebih dahulu (tersedia di sebagian versi Dify).
        try {
            $response = Http::withToken($this->knowledgeApiKey)
                ->acceptJson()
                ->timeout(15)
                ->get("{$this->baseUrl}/datasets/{$this->datasetId}/documents/{$difyDocumentId}/indexing-status");

            if ($response->successful()) {
                $document = collect($response->json('data', []))->first();

                return [
                    'success' => true,
                    'status' => $document['indexing_status'] ?? null,
                    'completed_segments' => $document['completed_segments'] ?? null,
                    'total_segments' => $document['total_segments'] ?? null,
                ];
            }
        } catch (Exception $e) {
            Log::channel('single')->warning('Dify IndexingStatus endpoint tidak tersedia, fallback ke list dokumen: ' . $e->getMessage());
        }

        // Fallback: ambil status dari daftar dokumen di dataset.
        $documents = $this->getDocuments();

        if (! $documents['success']) {
            return $this->error($documents['message'] ?? 'Gagal mengambil status dokumen.');
        }

        $document = collect($documents['documents'])->firstWhere('id', $difyDocumentId);

        if (! $document) {
            return $this->error("Dokumen {$difyDocumentId} tidak ditemukan di knowledge base.");
        }

        return [
            'success' => true,
            'status' => $document['indexing_status'] ?? null,
            'completed_segments' => $document['completed_segments'] ?? null,
            'total_segments' => $document['total_segments'] ?? null,
        ];
    }

    /**
     * Hapus dokumen dari Dify Knowledge Base.
     *
     * @return array{success: bool, message?: string}
     */
    public function deleteDocument(string $difyDocumentId): array
    {
        if (! $this->isKnowledgeConfigured()) {
            return $this->error('DIFY_KNOWLEDGE_API_KEY atau DIFY_DATASET_ID belum dikonfigurasi.');
        }

        try {
            $response = Http::withToken($this->knowledgeApiKey)
                ->acceptJson()
                ->timeout(15)
                ->delete("{$this->baseUrl}/datasets/{$this->datasetId}/documents/{$difyDocumentId}");

            if ($response->failed()) {
                return $this->error('Gagal menghapus dokumen dari Dify (' . $response->status() . '): ' . $this->extractErrorMessage($response));
            }

            return ['success' => true];
        } catch (Exception $e) {
            Log::channel('single')->error('Dify Delete Exception: ' . $e->getMessage());

            return $this->error($e->getMessage());
        }
    }

    /**
     * Susun nama file untuk Dify tanpa menimbulkan ekstensi ganda.
     */
    public static function buildDocumentName(string $namaFile, ?string $extension): string
    {
        $namaFile = trim($namaFile);
        $extension = strtolower((string) $extension);

        if (filled($extension) && ! str_ends_with(strtolower($namaFile), ".{$extension}")) {
            $namaFile .= ".{$extension}";
        }

        return $namaFile;
    }

    /**
     * Resolve absolute path dari file yang disimpan Filament di disk public.
     */
    public function resolveStoredFilePath(?string $relativePath): ?string
    {
        if (blank($relativePath)) {
            return null;
        }

        $fullPath = Storage::disk('public')->path($relativePath);

        return is_file($fullPath) ? $fullPath : null;
    }

    protected function extractErrorMessage(Response $response): string
    {
        $body = $response->json();

        if (is_array($body)) {
            if (isset($body['message'])) {
                return is_array($body['message']) ? json_encode($body['message']) : (string) $body['message'];
            }

            if (isset($body['error']) && is_string($body['error'])) {
                return $body['error'];
            }
        }

        return Str::limit($response->body(), 300);
    }

    /**
     * @return array{success: false, message: string}
     */
    protected function error(string $message): array
    {
        return [
            'success' => false,
            'message' => $message,
        ];
    }
}
