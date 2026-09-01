<?php

namespace App\Livewire\Warga;

use App\Models\ChatHistory;
use App\Models\ChatSession;
use App\Services\DifyService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatbotWidget extends Component
{
    public bool $isOpen = false;
    public string $query = '';
    public bool $isLoading = false;
    public ?string $conversationId = null;
    public array $messages = [];

    /** Teks jawaban yang sedang di-streaming (untuk wire:stream). */
    public string $streamedAnswer = '';

    public function mount()
    {
        // Initial greeting message from Assistant
        $this->messages[] = [
            'sender' => 'bot',
            'text' => 'Halo! Saya Asisten AI Desa Rombiyah Barat 🤖. Ada yang bisa saya bantu terkait syarat surat, SOP pelayanan, atau informasi desa?',
            'sources' => [],
            'time' => date('H:i'),
        ];

        // Lanjutkan percakapan Dify terakhir milik user yang sedang login
        if (Auth::check()) {
            $lastSession = ChatSession::where('user_id', Auth::id())
                ->whereNotNull('dify_conversation_id')
                ->latest('id')
                ->first();

            if ($lastSession) {
                $this->conversationId = $lastSession->dify_conversation_id;
            }
        }
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function sendMessage()
    {
        $userQuery = trim($this->query);
        if (empty($userQuery)) {
            return;
        }

        // Add user message to UI
        $this->messages[] = [
            'sender' => 'user',
            'text' => $userQuery,
            'sources' => [],
            'time' => date('H:i'),
        ];

        $this->query = '';
        $this->isLoading = true;
        $this->streamedAnswer = '';

        $userId = Auth::check() ? 'warga-' . Auth::id() : 'guest-' . session()->getId();

        /** @var DifyService $difyService */
        $difyService = app(DifyService::class);

        // Streaming: kirim potongan jawaban ke browser secara real-time.
        $result = $difyService->streamMessage(
            $userQuery,
            function (string $partial) {
                $this->streamedAnswer = $partial;
                $this->stream($partial, replace: true, name: 'answer');
            },
            $this->conversationId,
            $userId
        );

        $this->isLoading = false;
        $this->streamedAnswer = '';

        if ($result['success']) {
            $this->conversationId = $result['conversation_id'] ?? $this->conversationId;

            $botResponseText = $result['answer'] ?? 'Maaf, saya belum menemukan jawaban yang tepat di dokumen desa.';
            $sources = $result['sources'] ?? [];

            // Add bot response to UI
            $this->messages[] = [
                'sender' => 'bot',
                'text' => $botResponseText,
                'sources' => $sources,
                'time' => date('H:i'),
            ];

            // Save to database if user is logged in
            if (Auth::check()) {
                $session = ChatSession::where('user_id', Auth::id())
                    ->latest('id')
                    ->first();

                if (! $session) {
                    $session = ChatSession::create([
                        'user_id' => Auth::id(),
                        'dify_conversation_id' => $this->conversationId,
                        'started_at' => now(),
                    ]);
                } elseif ($session->dify_conversation_id !== $this->conversationId) {
                    $session->update(['dify_conversation_id' => $this->conversationId]);
                }

                ChatHistory::create([
                    'chat_session_id' => $session->id,
                    'pertanyaan' => $userQuery,
                    'jawaban' => $botResponseText,
                    'sumber' => ! empty($sources) ? $sources : null,
                ]);
            }
        } else {
            $this->messages[] = [
                'sender' => 'bot',
                'text' => $result['message'] ?? 'Maaf, layanan AI sedang mengalami kendala. Silakan coba beberapa saat lagi.',
                'sources' => [],
                'time' => date('H:i'),
            ];
        }
    }

    public function render()
    {
        return view('livewire.warga.chatbot-widget');
    }
}
