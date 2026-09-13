<?php

namespace App\Filament\Resources\PermohonanSuratResource\Pages;

use App\Filament\Resources\PermohonanSuratResource;
use App\Models\PermohonanSurat;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPermohonanSurat extends ViewRecord
{
    protected static string $resource = PermohonanSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('unduh_pdf')
                ->label('Unduh PDF Surat')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->visible(fn (): bool => $this->getRecord()->status === 'disetujui')
                ->url(fn (): string => route('warga.surat.pdf', $this->getRecord()->id))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }
}
