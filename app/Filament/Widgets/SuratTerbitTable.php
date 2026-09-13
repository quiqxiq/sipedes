<?php

namespace App\Filament\Widgets;

use App\Models\PermohonanSurat;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class SuratTerbitTable extends TableWidget
{
    protected static ?string $heading = 'Daftar Surat Terbit (Disetujui)';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->heading('Surat Terbit & Siap Diunduh')
            ->description('Seluruh permohonan surat warga yang telah diverifikasi dan disetujui secara resmi.')
            ->query(
                PermohonanSurat::query()
                    ->with(['user', 'jenisSurat', 'petugas'])
                    ->where('status', 'disetujui')
                    ->latest('tanggal_selesai')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nomor_permohonan')
                    ->label('No. Permohonan')
                    ->weight('bold')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pemohon')
                    ->searchable()
                    ->description(fn (PermohonanSurat $record) => $record->user?->nik ? 'NIK: ' . $record->user->nik : null),

                Tables\Columns\TextColumn::make('jenisSurat.nama')
                    ->label('Jenis Surat')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->label('Tanggal Terbit')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('petugas.name')
                    ->label('Petugas Penandatangan / Verifikator')
                    ->placeholder('Pamong / Administrator'),
            ])
            ->actions([
                Actions\Action::make('unduh_pdf')
                    ->label('Unduh PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn (PermohonanSurat $record): string => route('warga.surat.pdf', $record->id))
                    ->openUrlInNewTab(),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
