<?php

namespace App\Filament\Pages;

use App\Services\WhatsAppService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class WhatsAppGateway extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan & Sistem';

    protected static ?string $navigationLabel = 'WhatsApp Gateway';

    protected static ?string $title = 'WhatsApp Gateway Pelayanan Desa';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.whatsapp-gateway';

    public array $status = [];
    public bool $isOnline = false;
    public bool $isConnected = false;
    public bool $isLoggedIn = false;
    public ?string $phone = null;
    public ?string $deviceName = null;
    public ?string $statusMessage = null;

    public ?string $qrCode = null;
    public bool $loadingQr = false;

    public string $pairingPhone = '';
    public ?string $pairingCode = null;
    public int $pairingExpiresIn = 0;
    public bool $loadingPairing = false;

    public string $activeTab = 'qr';

    public string $testPhone = '';
    public string $testMessage = 'Halo! Ini adalah pesan uji coba dari SIPEDES WhatsApp Gateway Desa Rombiya Barat.';
    public bool $sendingTest = false;

    public ?string $feedbackMessage = null;
    public string $feedbackType = 'info';

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public function mount(WhatsAppService $waService): void
    {
        $defaultPhone = (string) config('whatsapp.petugas_phone', '082334567890');
        $this->pairingPhone = $defaultPhone;
        $this->testPhone = $defaultPhone;

        $this->refreshStatus($waService);

        if (!$this->isLoggedIn) {
            $this->fetchQr($waService);
        }
    }

    public function refreshStatus(WhatsAppService $waService): void
    {
        $this->status = $waService->checkStatus();
        $this->isOnline = (bool) ($this->status['online'] ?? false);
        $this->isConnected = (bool) ($this->status['connected'] ?? false);
        $this->isLoggedIn = (bool) ($this->status['logged_in'] ?? false);
        $this->phone = $this->status['phone'] ?? null;
        $this->deviceName = $this->status['device_name'] ?? 'Balai Desa Rombiya Barat';
        $this->statusMessage = $this->status['message'] ?? null;
    }

    public function pollStatus(WhatsAppService $waService): void
    {
        $previouslyLoggedIn = $this->isLoggedIn;
        $this->refreshStatus($waService);

        if (!$previouslyLoggedIn && $this->isLoggedIn) {
            $this->qrCode = null;
            $this->pairingCode = null;

            Notification::make()
                ->title('WhatsApp Berhasil Terhubung!')
                ->body('Perangkat nomor ' . ($this->phone ?? 'Balai Desa') . ' telah aktif terhubung.')
                ->success()
                ->send();
        }
    }

    public function fetchQr(WhatsAppService $waService): void
    {
        $this->loadingQr = true;
        try {
            $res = $waService->getQrCode();
            if ($res['success'] && !empty($res['qr'])) {
                $this->qrCode = $res['qr'];
                $this->isLoggedIn = (bool) ($res['logged_in'] ?? false);
                $this->isConnected = (bool) ($res['connected'] ?? false);
            } else {
                $this->qrCode = null;
                $this->statusMessage = $res['message'] ?? 'Gagal mengambil QR code.';
            }
        } finally {
            $this->loadingQr = false;
        }
    }

    public function requestPairingCode(WhatsAppService $waService): void
    {
        $this->validate([
            'pairingPhone' => ['required', 'string', 'min:9', 'max:20'],
        ], [
            'pairingPhone.required' => 'Nomor telepon WhatsApp wajib diisi.',
            'pairingPhone.min' => 'Nomor telepon minimal 9 digit.',
        ]);

        $this->loadingPairing = true;
        $this->feedbackMessage = null;

        try {
            $res = $waService->requestPairingCode($this->pairingPhone);

            if ($res['success'] && !empty($res['code'])) {
                $this->pairingCode = $res['code'];
                $this->pairingExpiresIn = $res['expires_in'] ?? 160;

                Notification::make()
                    ->title('Kode Pairing Berhasil Dibuat!')
                    ->body("Masukkan kode {$this->pairingCode} di menu Perangkat Tertaut WhatsApp HP Anda.")
                    ->success()
                    ->send();
            } else {
                $this->pairingCode = null;
                $msg = $res['message'] ?? 'Gagal membuat kode pairing dari gateway.';

                Notification::make()
                    ->title('Gagal Membuat Pairing Code')
                    ->body($msg)
                    ->danger()
                    ->send();
            }
        } finally {
            $this->loadingPairing = false;
        }
    }

    public function disconnect(WhatsAppService $waService): void
    {
        $success = $waService->logout();
        $this->qrCode = null;
        $this->pairingCode = null;
        $this->refreshStatus($waService);

        if ($success) {
            Notification::make()
                ->title('Tautan WhatsApp Diputuskan')
                ->body('Sesi WhatsApp berhasil dikeluarkan.')
                ->warning()
                ->send();
        } else {
            Notification::make()
                ->title('Pemberitahuan')
                ->body('Permintaan logout dikirim ke gateway.')
                ->info()
                ->send();
        }
    }

    public function sendTestMessage(WhatsAppService $waService): void
    {
        $this->validate([
            'testPhone' => ['required', 'string', 'min:9'],
            'testMessage' => ['required', 'string', 'max:500'],
        ], [
            'testPhone.required' => 'Nomor tujuan uji coba wajib diisi.',
            'testMessage.required' => 'Isi pesan uji coba wajib diisi.',
        ]);

        $this->sendingTest = true;
        $this->feedbackMessage = null;

        try {
            $sent = $waService->sendMessage(
                $this->testPhone,
                $this->testMessage,
                'sistem',
                null,
                'Uji Coba Admin'
            );

            if ($sent) {
                $this->feedbackType = 'success';
                $this->feedbackMessage = 'Pesan uji coba berhasil terkirim ke nomor ' . $this->testPhone;

                Notification::make()
                    ->title('Pesan WhatsApp Terkirim!')
                    ->body('Pesan tes berhasil dikirim via WhatsApp Gateway.')
                    ->success()
                    ->send();
            } else {
                $err = $waService->getLastError() ?: 'Pastikan nomor valid dan WhatsApp Gateway dalam status terhubung.';
                $this->feedbackType = 'danger';
                $this->feedbackMessage = 'Gagal mengirim pesan: ' . $err;

                Notification::make()
                    ->title('Gagal Mengirim Pesan')
                    ->body($err)
                    ->danger()
                    ->send();
            }
        } finally {
            $this->sendingTest = false;
        }
    }
}
