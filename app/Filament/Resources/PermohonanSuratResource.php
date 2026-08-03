<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermohonanSuratResource\Pages;
use App\Models\AktivitasLog;
use App\Models\Notifikasi;
use App\Models\PermohonanSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PermohonanSuratResource extends Resource
{
    protected static ?string $model = PermohonanSurat::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Layanan Desa';

    protected static ?string $navigationLabel = 'Permohonan Surat';

    protected static ?string $modelLabel = 'Permohonan Surat';

    protected static ?string $pluralModelLabel = 'Permohonan Surat';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Permohonan')
                    ->schema([
                        Forms\Components\TextInput::make('nomor_permohonan')
                            ->label('Nomor Permohonan')
                            ->required()
                            ->readOnly(),

                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Warga Pemohon')
                            ->searchable()
                            ->required()
                            ->disabled(),

                        Forms\Components\Select::make('jenis_surat_id')
                            ->relationship('jenisSurat', 'nama')
                            ->label('Jenis Surat')
                            ->required()
                            ->disabled(),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'diajukan' => 'Diajukan',
                                'diproses' => 'Diproses',
                                'disetujui' => 'Disetujui',
                                'ditolak' => 'Ditolak',
                                'butuh_koreksi' => 'Butuh Koreksi',
                            ])
                            ->required(),

                        Forms\Components\Select::make('petugas_id')
                            ->relationship('petugas', 'name', fn (Builder $query) => $query->whereIn('role', ['petugas', 'admin']))
                            ->label('Petugas Verifikator')
                            ->searchable()
                            ->nullable(),

                        Forms\Components\Textarea::make('catatan_petugas')
                            ->label('Catatan Petugas')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Berkas Lampiran')
                    ->schema([
                        Forms\Components\FileUpload::make('file_pdf')
                            ->label('File PDF Surat Resmi (Hasil Generate)')
                            ->directory('surat-resmi')
                            ->acceptedFileTypes(['application/pdf'])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_permohonan')
                    ->label('No. Permohonan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pemohon')
                    ->searchable()
                    ->description(fn (PermohonanSurat $record) => $record->user?->nik ? 'NIK: ' . substr($record->user->nik, 0, 6) . '******' : null),

                Tables\Columns\TextColumn::make('jenisSurat.nama')
                    ->label('Jenis Surat')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'diajukan' => 'warning',
                        'diproses' => 'info',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        'butuh_koreksi' => 'amber',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'diajukan' => 'Diajukan',
                        'diproses' => 'Diproses',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                        'butuh_koreksi' => 'Butuh Koreksi',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('petugas.name')
                    ->label('Petugas')
                    ->placeholder('Belum ditangani'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'diajukan' => 'Diajukan',
                        'diproses' => 'Diproses',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                        'butuh_koreksi' => 'Butuh Koreksi',
                    ]),

                Tables\Filters\SelectFilter::make('jenis_surat_id')
                    ->relationship('jenisSurat', 'nama')
                    ->label('Jenis Surat'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('setujui')
                    ->label('Setujui & Proses')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (PermohonanSurat $record) => in_array($record->status, ['diajukan', 'diproses', 'butuh_koreksi']))
                    ->form([
                        Forms\Components\Textarea::make('catatan_petugas')
                            ->label('Catatan Tambahan (Opsional)'),
                    ])
                    ->action(function (PermohonanSurat $record, array $data): void {
                        $record->update([
                            'status' => 'disetujui',
                            'petugas_id' => Auth::id(),
                            'catatan_petugas' => $data['catatan_petugas'] ?? 'Permohonan surat disetujui.',
                            'tanggal_selesai' => now(),
                        ]);

                        Notifikasi::create([
                            'user_id' => $record->user_id,
                            'permohonan_id' => $record->id,
                            'judul' => 'Permohonan Surat Disetujui',
                            'pesan' => "Permohonan {$record->jenisSurat?->nama} (No: {$record->nomor_permohonan}) telah disetujui dan siap diunduh.",
                        ]);

                        AktivitasLog::catat(Auth::id(), 'surat', 'verifikasi', "Menyetujui permohonan surat #{$record->nomor_permohonan}");

                        Notification::make()
                            ->title('Permohonan berhasil disetujui')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('minta_koreksi')
                    ->label('Minta Koreksi')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->visible(fn (PermohonanSurat $record) => in_array($record->status, ['diajukan', 'diproses']))
                    ->form([
                        Forms\Components\Textarea::make('catatan_petugas')
                            ->label('Alasan / Bagian yang Perlu Dikoreksi')
                            ->required(),
                    ])
                    ->action(function (PermohonanSurat $record, array $data): void {
                        $record->update([
                            'status' => 'butuh_koreksi',
                            'petugas_id' => Auth::id(),
                            'catatan_petugas' => $data['catatan_petugas'],
                        ]);

                        Notifikasi::create([
                            'user_id' => $record->user_id,
                            'permohonan_id' => $record->id,
                            'judul' => 'Koreksi Berkas Permohonan Surat',
                            'pesan' => "Permohonan {$record->jenisSurat?->nama} membutuhkan koreksi: {$data['catatan_petugas']}",
                        ]);

                        AktivitasLog::catat(Auth::id(), 'surat', 'minta_koreksi', "Meminta koreksi permohonan #{$record->nomor_permohonan}");

                        Notification::make()
                            ->title('Permohonan dikembalikan ke pemohon untuk koreksi')
                            ->warning()
                            ->send();
                    }),

                Tables\Actions\Action::make('tolak')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (PermohonanSurat $record) => in_array($record->status, ['diajukan', 'diproses', 'butuh_koreksi']))
                    ->form([
                        Forms\Components\Textarea::make('catatan_petugas')
                            ->label('Alasan Penolakan')
                            ->required(),
                    ])
                    ->action(function (PermohonanSurat $record, array $data): void {
                        $record->update([
                            'status' => 'ditolak',
                            'petugas_id' => Auth::id(),
                            'catatan_petugas' => $data['catatan_petugas'],
                        ]);

                        Notifikasi::create([
                            'user_id' => $record->user_id,
                            'permohonan_id' => $record->id,
                            'judul' => 'Permohonan Surat Ditolak',
                            'pesan' => "Permohonan {$record->jenisSurat?->nama} ditolak. Alasan: {$data['catatan_petugas']}",
                        ]);

                        AktivitasLog::catat(Auth::id(), 'surat', 'penolakan', "Menolak permohonan #{$record->nomor_permohonan}");

                        Notification::make()
                            ->title('Permohonan berhasil ditolak')
                            ->danger()
                            ->send();
                    }),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Detail Permohonan Surat')
                    ->schema([
                        Infolists\Components\TextEntry::make('nomor_permohonan')->label('No. Permohonan'),
                        Infolists\Components\TextEntry::make('user.name')->label('Nama Pemohon'),
                        Infolists\Components\TextEntry::make('user.nik')->label('NIK Pemohon'),
                        Infolists\Components\TextEntry::make('user.telepon')->label('Telepon/WA'),
                        Infolists\Components\TextEntry::make('jenisSurat.nama')->label('Jenis Surat'),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'diajukan' => 'warning',
                                'diproses' => 'info',
                                'disetujui' => 'success',
                                'ditolak' => 'danger',
                                'butuh_koreksi' => 'amber',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('petugas.name')->label('Petugas Verifikator')->placeholder('-'),
                        Infolists\Components\TextEntry::make('created_at')->label('Tanggal Pengajuan')->dateTime('d M Y H:i'),
                        Infolists\Components\TextEntry::make('catatan_petugas')->label('Catatan Petugas')->columnSpanFull()->placeholder('-'),
                    ])->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermohonanSurats::route('/'),
            'view' => Pages\ViewPermohonanSurat::route('/{record}'),
            'edit' => Pages\EditPermohonanSurat::route('/{record}/edit'),
        ];
    }
}
