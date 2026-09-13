<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratTerbitResource\Pages;
use App\Models\PermohonanSurat;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SuratTerbitResource extends Resource
{
    protected static ?string $model = PermohonanSurat::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-check-badge';

    protected static string|\UnitEnum|null $navigationGroup = 'Layanan Desa';

    protected static ?string $navigationLabel = 'Surat Terbit';

    protected static ?string $modelLabel = 'Surat Terbit';

    protected static ?string $pluralModelLabel = 'Surat Terbit';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $count = PermohonanSurat::where('status', 'disetujui')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                PermohonanSurat::query()
                    ->with(['user', 'jenisSurat', 'petugas'])
                    ->where('status', 'disetujui')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nomor_permohonan')
                    ->label('No. Permohonan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pemohon')
                    ->searchable()
                    ->description(fn (PermohonanSurat $record) => $record->user?->nik ? 'NIK: ' . $record->user->nik : null),

                Tables\Columns\TextColumn::make('jenisSurat.nama')
                    ->label('Jenis Surat')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->label('Tanggal Terbit')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('petugas.name')
                    ->label('Petugas Verifikator')
                    ->placeholder('-'),
            ])
            ->defaultSort('tanggal_selesai', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_surat_id')
                    ->relationship('jenisSurat', 'nama')
                    ->label('Jenis Surat'),
            ])
            ->actions([
                Actions\Action::make('unduh_pdf')
                    ->label('Unduh PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn (PermohonanSurat $record): string => route('warga.surat.pdf', $record->id))
                    ->openUrlInNewTab(),

                Actions\Action::make('lihat_detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn (PermohonanSurat $record): string => PermohonanSuratResource::getUrl('view', ['record' => $record])),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratTerbits::route('/'),
        ];
    }
}
