# Analisis & Spesifikasi Pemanggilan API Dify (Self-Hosted RAG)

Dokumen ini berisi analisis teknis dan spesifikasi lengkap pemanggilan API **Dify** untuk aplikasi **SIPEDES (Sistem Informasi Pelayanan Desa Rombiyah Barat)**.

---

## 1. Ringkasan Hasil Pemeriksaan Web UI Dify

- **URL Dashboard Dify**: `http://localhost:3000/app/0dcb6bd4-109f-4629-8591-f9e030958e2b/develop`
- **Status Browser**: Navigasi ke Web UI Dify membutuhkan autentikasi (`/signin`).
- **Kunci API Aplikasi yang Digunakan**: `app-6XEEPQQqIckkqCSg7c0DPmCr`

---

## 2. Arsitektur Pemanggilan API Dify

Sesuai standar REST API resmi Dify (Chat App / Workflow App), seluruh komunikasi dari Laravel ke Dify dilakukan melalui protokol **HTTP REST** menggunakan header otentikasi `Bearer Token`.

```
┌─────────────────────────┐          HTTP REST API (Guzzle)          ┌─────────────────────────┐
│     Laravel Backend     │ ───────────────────────────────────────> │    Dify Self-Hosted     │
│   (App\Services\Dify)   │ <─────────────────────────────────────── │     (Docker Container)  │
└─────────────────────────┘      Header: Authorization: Bearer       └─────────────────────────┘
```

### Parameter Konfigurasi Lingkungan (`.env`)
```env
DIFY_BASE_URL=http://localhost/v1
DIFY_API_KEY=app-6XEEPQQqIckkqCSg7c0DPmCr
DIFY_KNOWLEDGE_API_KEY=dataset-xxxxxxxxxxxxxxxx
DIFY_DATASET_ID=xxxxxxxx-xxxx-xxxx
```

---

## 3. Spesifikasi Endpoint API Dify

### 3.1. Kirim Pesan Chatbot (`POST /chat-messages`)

Endpoint ini digunakan oleh portal warga untuk mengirim pertanyaan ke Chatbot RAG desa dan menerima balasan beserta sumber dokumen acuan.

- **URL**: `{DIFY_BASE_URL}/chat-messages`
- **Method**: `POST`
- **Headers**:
  ```http
  Authorization: Bearer app-6XEEPQQqIckkqCSg7c0DPmCr
  Content-Type: application/json
  ```

#### Request Payload Structure (`JSON`)
```json
{
  "inputs": {},
  "query": "Apa saja syarat pembuatan Surat Keterangan Usaha (SKU)?",
  "response_mode": "blocking",
  "conversation_id": "",
  "user": "warga-1029384756",
  "files": []
}
```

#### Penjelasan Field Request:
| Field | Tipe Data | Wajib? | Deskripsi |
| :--- | :--- | :--- | :--- |
| `inputs` | `object` | **Ya** | Variabel input kustom yang didefinisikan pada prompt Dify. Isi `{}` jika tidak ada. |
| `query` | `string` | **Ya** | Teks pertanyaan dari pemohon/warga. |
| `response_mode` | `string` | **Ya** | `"blocking"` (menunggu jawaban lengkap dari Dify sebelum me-return JSON) atau `"streaming"` (output respons secara real-time / SSE stream). |
| `conversation_id` | `string` | **Tidak** | ID Percakapan Dify. Isi string kosong `""` pada pesan pertama untuk memulai sesi baru. Isi ID dari respons sebelumnya untuk melanjutkan percakapan multi-turn. |
| `user` | `string` | **Ya** | Unique identifier warga/pengguna (misal: ID user atau NIK). Mencegah kebocoran memori percakapan antar warga. |
| `files` | `array` | **Tidak** | Array file jika menggunakan fitur vision/multimodal. |

#### Response Structure (`response_mode: blocking`)
```json
{
  "event": "message",
  "message_id": "9a2d3e4f-5678-90ab-cdef-1234567890ab",
  "conversation_id": "d0c9b4d8-1d7f-40d3-a6cc-6c8a883d8536",
  "mode": "chat",
  "answer": "Berikut adalah syarat pembuatan Surat Keterangan Usaha (SKU) di Desa Rombiyah Barat:\n1. Fotokopi KTP Pemohon\n2. Fotokopi Kartu Keluarga (KK)\n3. Surat Pengantar RT/RW\n4. Foto Lokasi Usaha",
  "metadata": {
    "retriever_resources": [
      {
        "position": 1,
        "dataset_id": "c1f2e3d4-5678-90ab-cdef-1234567890ab",
        "dataset_name": "SOP Pelayanan Desa",
        "document_id": "doc-99887766",
        "document_name": "SOP_Surat_Keterangan_Usaha.pdf",
        "segment_id": "seg-112233",
        "score": 0.92,
        "content": "Syarat SKU meliputi KTP, KK, pengantar RT/RW, dan foto tempat usaha..."
      }
    ]
  },
  "created_at": 1723060000
}
```

---

### 3.2. Upload & Indexing Dokumen Pengetahuan (`POST /datasets/{dataset_id}/document/create-by-file`)

Endpoint ini digunakan oleh Admin Desa untuk mengunggah dokumen SOP/Perdes ke Knowledge Base Dify agar di-chunk dan di-embed ke Vector Database.

- **URL**: `{DIFY_BASE_URL}/datasets/{dataset_id}/document/create-by-file`
- **Method**: `POST`
- **Headers**:
  ```http
  Authorization: Bearer dataset-xxxxxxxxxxxxxxxx
  Content-Type: multipart/form-data
  ```
- **Form Data**:
  - `file`: File fisik (PDF, DOCX, TXT)
  - `data`: Stringified JSON konfigurasi pemrosesan
    ```json
    {
      "indexing_technique": "high_quality",
      "process_rule": {
        "mode": "automatic"
      }
    }
    ```

#### Response Structure:
```json
{
  "document": {
    "id": "doc-99887766-5544-3322-1100",
    "position": 1,
    "data_source_type": "upload_file",
    "name": "SOP_Surat_Keterangan_Usaha.pdf",
    "indexing_status": "indexing",
    "created_at": 1723060050
  },
  "batch": "batch-12345"
}
```

---

### 3.3. Cek Status Indexing Dokumen (`GET /datasets/{dataset_id}/documents/{document_id}/indexing-status`)

- **Method**: `GET`
- **Headers**: `Authorization: Bearer dataset-xxxxxxxxxxxxxxxx`
- **Response**:
  ```json
  {
    "data": [
      {
        "id": "doc-99887766-5544-3322-1100",
        "indexing_status": "completed",
        "processing_started_at": 1723060052,
        "parsing_completed_at": 1723060058,
        "cleaning_completed_at": 1723060060,
        "split_completed_at": 1723060062,
        "completed_at": 1723060070,
        "completed_segments": 14,
        "total_segments": 14
      }
    ]
  }
  ```

---

### 3.4. Hapus Dokumen dari Knowledge Base (`DELETE /datasets/{dataset_id}/documents/{document_id}`)

- **Method**: `DELETE`
- **Headers**: `Authorization: Bearer dataset-xxxxxxxxxxxxxxxx`
- **Response**:
  ```json
  {
    "result": "success"
  }
  ```

---

## 4. Contoh Implementasi Client Service Laravel (`App\Services\DifyService`)

Berikut adalah struktur teruji pemanggilan Dify API di Laravel menggunakan Guzzle HTTP client:

```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class DifyService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.dify.base_url', 'http://localhost/v1');
        $this->apiKey = config('services.dify.api_key');
    }

    /**
     * Kirim pertanyaan ke Chatbot Dify (Blocking mode)
     */
    public function sendMessage(string $query, ?string $conversationId = null, string $userId = 'guest'): array
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(20)
                ->post("{$this->baseUrl}/chat-messages", [
                    'inputs' => new \stdClass(),
                    'query' => $query,
                    'response_mode' => 'blocking',
                    'conversation_id' => $conversationId ?? '',
                    'user' => $userId,
                ]);

            if ($response->failed()) {
                Log::channel('dify')->error('Dify API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                
                return [
                    'success' => false,
                    'message' => 'Maaf, layanan chatbot sedang tidak dapat dijangkau.',
                ];
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
            Log::channel('dify')->error('Dify Exception: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menghubungi AI.',
            ];
        }
    }
}
```

---

## 5. Kesimpulan & Rekomendasi

1. **Keamanan & Isolasasi Sesi**: Parameter `user` wajib diisi unik per warga (misal ID user Laravel) agar memory history Dify tidak tercampur antara satu pemohon dengan pemohon lainnya.
2. **Conversation Tracking**: Simpan `conversation_id` balikan dari Dify ke tabel `chat_session` di MySQL Laravel agar warga bisa menanyakan pertanyaan lanjutan (*multi-turn dialogue*).
3. **Handling Timeout**: Karena LLM dan RAG membutuhkan waktu pemrosesan 2-8 detik, disarankan mengatur timeout Guzzle minimal **20 detik** dan memberikan pesan *fallback* yang ramah jika server Dify sedang padat.
