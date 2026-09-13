<?php

namespace App\Services;

use App\Models\WhatsAppLog;
use App\Models\WhatsAppTemplate;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected bool $enabled;
    protected int $timeout;
    protected ?string $lastError = null;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('whatsapp.gateway_url', 'http://127.0.0.1:3100'), '/');
        $this->apiKey = (string) config('whatsapp.api_key', 'sipedes_secret_wa_2026');
        $this->enabled = (bool) config('whatsapp.enabled', true);
        $this->timeout = (int) config('whatsapp.timeout', 8);
    }

    public function getLastError(): ?string
    {
        return $this->lastError;
    }

    /**
     * Normalisasi nomor telepon ke format standar 628xxx
     */
    public function formatPhoneNumber(string $phone): string
    {
        // Buang karakter selain angka
        $cleaned = preg_replace('/[^0-9]/', '', $phone);

        if (empty($cleaned)) {
            return '';
        }

        // Jika diawali 08, ganti 0 dengan 62
        if (str_starts_with($cleaned, '0')) {
            $cleaned = '62' . substr($cleaned, 1);
        }

        // Jika diawali 8 (tanpa 0 atau 62), tambahkan 62
        if (str_starts_with($cleaned, '8')) {
            $cleaned = '62' . $cleaned;
        }

        return $cleaned;
    }

    /**
     * Cek status koneksi WhatsApp Gateway (Go-WA)
     */
    public function checkStatus(): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders(['X-Api-Key' => $this->apiKey])
                ->get("{$this->baseUrl}/app/status");

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'online' => true,
                    'connected' => (bool) ($data['connected'] ?? false),
                    'logged_in' => (bool) ($data['logged_in'] ?? false),
                    'phone' => $data['phone'] ?? null,
                    'device_name' => $data['device_name'] ?? 'Go-WA Gateway',
                    'battery' => $data['battery'] ?? null,
                    'message' => 'Layanan WhatsApp Gateway Aktif dan Terhubung.',
                ];
            }

            return [
                'online' => false,
                'connected' => false,
                'logged_in' => false,
                'phone' => null,
                'message' => 'Layanan Gateway merespons dengan kode HTTP ' . $response->status(),
            ];
        } catch (Exception $e) {
            return [
                'online' => false,
                'connected' => false,
                'logged_in' => false,
                'phone' => null,
                'message' => 'Layanan Go-WA Docker belum aktif atau tidak dapat dijangkau: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Dapatkan QR Code live untuk pairing scan kamera
     */
    public function getQrCode(): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders(['X-Api-Key' => $this->apiKey])
                ->get("{$this->baseUrl}/app/qr");

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'qr' => $data['qr_code'] ?? null, // base64 data uri
                    'raw' => $data['raw'] ?? null,
                    'connected' => (bool) ($data['connected'] ?? false),
                    'logged_in' => (bool) ($data['logged_in'] ?? false),
                    'message' => 'QR Code berhasil diperoleh.',
                ];
            }

            return [
                'success' => false,
                'qr' => null,
                'message' => 'Gagal mengambil QR Code dari gateway.',
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'qr' => null,
                'message' => 'Gagal terhubung ke gateway: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Minta Pairing Code 8-Karakter WhatsApp Multi-Device via nomor HP
     */
    public function requestPairingCode(string $phone): array
    {
        $formattedPhone = $this->formatPhoneNumber($phone);
        if (empty($formattedPhone)) {
            return [
                'success' => false,
                'code' => null,
                'message' => 'Nomor telepon tidak valid.',
            ];
        }

        try {
            $response = Http::timeout(15)
                ->withHeaders(['X-Api-Key' => $this->apiKey])
                ->post("{$this->baseUrl}/app/pairing-code", [
                    'phone' => $formattedPhone,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'code' => $data['pairing_code'] ?? ($data['code'] ?? null),
                    'expires_in' => $data['expires_in'] ?? 160,
                    'message' => 'Kode pairing berhasil dibuat. Masukkan kode ini pada WhatsApp di HP Anda.',
                ];
            }

            $error = $response->json('message') ?? 'Gagal membuat kode pairing dari gateway.';
            return [
                'success' => false,
                'code' => null,
                'message' => $error,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'code' => null,
                'message' => 'Gagal terhubung ke gateway: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Putuskan sesi WhatsApp / Logout
     */
    public function logout(): bool
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders(['X-Api-Key' => $this->apiKey])
                ->post("{$this->baseUrl}/app/logout");

            return $response->successful();
        } catch (Exception $e) {
            Log::error("Go-WA Logout Error: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Kirim pesan teks WhatsApp biasa
     */
    public function sendMessage(
        string $phone,
        string $message,
        string $tipePesan = 'sistem',
        ?int $refId = null,
        ?string $namaPenerima = null
    ): bool {
        $formattedPhone = $this->formatPhoneNumber($phone);

        if (empty($formattedPhone)) {
            Log::warning("WhatsApp send aborted: Invalid phone number '{$phone}'");
            return false;
        }

        // Catat log awal status pending
        $log = WhatsAppLog::create([
            'nomor_tujuan' => $formattedPhone,
            'nama_penerima' => $namaPenerima,
            'tipe_pesan' => $tipePesan,
            'referensi_id' => $refId,
            'pesan' => $message,
            'status' => 'pending',
        ]);

        if (!$this->enabled) {
            $log->update([
                'status' => 'failed',
                'error_message' => 'Pengiriman WhatsApp dinonaktifkan di konfigurasi (WHATSAPP_NOTIFICATION_ENABLED=false).',
            ]);
            return false;
        }

        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders(['X-Api-Key' => $this->apiKey])
                ->post("{$this->baseUrl}/send/message", [
                    'phone' => $formattedPhone,
                    'message' => $message,
                ]);

            if ($response->successful()) {
                $log->update([
                    'status' => 'sent',
                    'response_payload' => $response->json(),
                    'sent_at' => now(),
                ]);
                return true;
            }

            $errDetail = $response->json('error') ?? $response->json('message') ?? ('HTTP ' . $response->status());
            $this->lastError = $errDetail;

            $log->update([
                'status' => 'failed',
                'response_payload' => $response->json(),
                'error_message' => 'Gateway merespons: ' . $errDetail,
            ]);
            return false;
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            Log::error("WhatsApp sendMessage Error: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Kirim pesan WhatsApp menggunakan template yang tersimpan
     */
    public function sendTemplate(
        string $kodeTemplate,
        string $phone,
        array $data,
        ?string $namaPenerima = null,
        ?int $refId = null
    ): bool {
        $template = WhatsAppTemplate::where('kode', $kodeTemplate)
            ->where('is_active', true)
            ->first();

        if (!$template) {
            Log::warning("WhatsApp Template '{$kodeTemplate}' tidak ditemukan atau tidak aktif.");
            return false;
        }

        $message = $template->render($data);
        return $this->sendMessage($phone, $message, $template->kategori, $refId, $namaPenerima);
    }

    /**
     * Kirim alert ke nomor pamong/petugas balai desa
     */
    public function notifyPetugas(string $kodeTemplate, array $data, ?int $refId = null): bool
    {
        $petugasPhone = config('whatsapp.petugas_phone');
        if (empty($petugasPhone)) {
            return false;
        }

        return $this->sendTemplate($kodeTemplate, $petugasPhone, $data, 'Petugas Pelayanan Desa', $refId);
    }
}
