<?php

namespace App\Filament\Resources\PengaduanResource\Pages;

use App\Filament\Resources\PengaduanResource;
use App\Jobs\SendWhatsAppNotificationJob;
use App\Models\AktivitasLog;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditPengaduan extends EditRecord
{
    protected static string $resource = PengaduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        AktivitasLog::catat(
            Auth::id(),
            'pengaduan',
            'tindak_lanjut_pengaduan',
            "Memperbarui status pengaduan {$this->record->kode_tiket} menjadi '{$this->record->status}'"
        );

        // Jika ada tanggapan atau status selesai, kirim notifikasi WhatsApp ke warga pelapor
        $user = $this->record->user;
        if ($user && !empty($user->telepon) && ($this->record->status === 'selesai' || !empty($this->record->tanggapan_petugas))) {
            SendWhatsAppNotificationJob::dispatch(
                'pengaduan_selesai_warga',
                $user->telepon,
                [
                    'nama_pelapor' => $user->name,
                    'kode_tiket' => $this->record->kode_tiket,
                    'judul_pengaduan' => $this->record->judul,
                    'tanggapan_petugas' => $this->record->tanggapan_petugas ?? 'Laporan telah selesai ditindaklanjuti oleh pamong desa.',
                ],
                $user->name,
                $this->record->id
            );
        }
    }
}
