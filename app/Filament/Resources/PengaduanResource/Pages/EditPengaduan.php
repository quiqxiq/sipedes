<?php

namespace App\Filament\Resources\PengaduanResource\Pages;

use App\Filament\Resources\PengaduanResource;
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
        AktivitasLog::log(
            Auth::user(),
            'tindak_lanjut_pengaduan',
            "Memperbarui status pengaduan {$this->record->kode_tiket} menjadi '{$this->record->status}'"
        );
    }
}
