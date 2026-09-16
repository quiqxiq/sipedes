<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermohonanSuratResource\Pages;
use App\Jobs\SendWhatsAppNotificationJob;
use App\Models\AktivitasLog;
use App\Models\Notifikasi;
use App\Models\PermohonanSurat;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PermohonanSuratResource extends Resource
{
    protected static ?string $model = PermohonanSurat::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|\UnitEnum|null $navigationGroup = 'Layanan Desa';

    protected static ?string $navigationLabel = 'Permohonan Surat';

    protected static ?string $modelLabel = 'Permohonan Surat';

    protected static ?string $pluralModelLabel = 'Permohonan Surat';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Permohonan')
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
                                'dibatalkan' => 'Dibatalkan',
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

                Section::make('Berkas Lampiran')
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
                        'dibatalkan' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'diajukan' => 'Diajukan',
                        'diproses' => 'Diproses',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                        'butuh_koreksi' => 'Butuh Koreksi',
                        'dibatalkan' => 'Dibatalkan',
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
                        'dibatalkan' => 'Dibatalkan',
                    ]),

                Tables\Filters\SelectFilter::make('jenis_surat_id')
                    ->relationship('jenisSurat', 'nama')
                    ->label('Jenis Surat'),
            ])
            ->actions([
                Actions\ActionGroup::make([
                    Actions\ViewAction::make()
                        ->label('Lihat Detail'),

                    Actions\Action::make('setujui')
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

                            // Kirim Notifikasi WhatsApp ke Pemohon
                            $user = $record->user;
                            if ($user && !empty($user->telepon)) {
                                SendWhatsAppNotificationJob::dispatch(
                                    'surat_disetujui_warga',
                                    $user->telepon,
                                    [
                                        'nama_pemohon' => $user->name,
                                        'jenis_surat' => $record->jenisSurat?->nama,
                                        'nomor_permohonan' => $record->nomor_permohonan,
                                        'tanggal_selesai' => now()->translatedFormat('d M Y H:i') . ' WIB',
                                        'link_download_pdf' => route('warga.surat.pdf', $record->id),
                                    ],
                                    $user->name,
                                    $record->id
                                );
                            }

                            AktivitasLog::catat(Auth::id(), 'surat', 'verifikasi', "Menyetujui permohonan surat #{$record->nomor_permohonan}");

                            Notification::make()
                                ->title('Permohonan berhasil disetujui')
                                ->success()
                                ->send();
                        }),

                    Actions\Action::make('minta_koreksi')
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

                            // Kirim Notifikasi WhatsApp ke Pemohon
                            $user = $record->user;
                            if ($user && !empty($user->telepon)) {
                                SendWhatsAppNotificationJob::dispatch(
                                    'surat_koreksi_warga',
                                    $user->telepon,
                                    [
                                        'nama_pemohon' => $user->name,
                                        'jenis_surat' => $record->jenisSurat?->nama,
                                        'nomor_permohonan' => $record->nomor_permohonan,
                                        'catatan_petugas' => $data['catatan_petugas'],
                                        'link_status' => route('warga.riwayat.show', $record->id),
                                    ],
                                    $user->name,
                                    $record->id
                                );
                            }

                            AktivitasLog::catat(Auth::id(), 'surat', 'minta_koreksi', "Meminta koreksi permohonan #{$record->nomor_permohonan}");

                            Notification::make()
                                ->title('Permohonan dikembalikan ke pemohon untuk koreksi')
                                ->warning()
                                ->send();
                        }),

                    Actions\Action::make('tolak')
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

                            // Kirim Notifikasi WhatsApp ke Pemohon
                            $user = $record->user;
                            if ($user && !empty($user->telepon)) {
                                SendWhatsAppNotificationJob::dispatch(
                                    'surat_ditolak_warga',
                                    $user->telepon,
                                    [
                                        'nama_pemohon' => $user->name,
                                        'jenis_surat' => $record->jenisSurat?->nama,
                                        'nomor_permohonan' => $record->nomor_permohonan,
                                        'catatan_petugas' => $data['catatan_petugas'],
                                    ],
                                    $user->name,
                                    $record->id
                                );
                            }

                            AktivitasLog::catat(Auth::id(), 'surat', 'penolakan', "Menolak permohonan #{$record->nomor_permohonan}");

                            Notification::make()
                                ->title('Permohonan berhasil ditolak')
                                ->danger()
                                ->send();
                        }),

                    Actions\Action::make('unduh_pdf')
                        ->label('Unduh PDF')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('success')
                        ->visible(fn (PermohonanSurat $record) => $record->status === 'disetujui')
                        ->url(fn (PermohonanSurat $record): string => route('warga.surat.pdf', $record->id))
                        ->openUrlInNewTab(),

                    Actions\DeleteAction::make()
                        ->label('Hapus Permohonan'),
                ])
                ->icon('heroicon-m-ellipsis-vertical')
                ->tooltip('Aksi Permohonan'),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Detail Permohonan Surat')
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
                                'dibatalkan' => 'gray',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('petugas.name')->label('Petugas Verifikator')->placeholder('-'),
                        Infolists\Components\TextEntry::make('created_at')->label('Tanggal Pengajuan')->dateTime('d M Y H:i'),
                        Infolists\Components\TextEntry::make('catatan_petugas')->label('Catatan Petugas')->columnSpanFull()->placeholder('-'),
                    ])->columns(2),

                Section::make('Berkas Persyaratan yang Diunggah Pemohon')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('dokumenPersyaratan')
                            ->label('Daftar Berkas')
                            ->schema([
                                Infolists\Components\TextEntry::make('tipe_dokumen')
                                    ->label('Jenis Berkas / Syarat')
                                    ->weight('bold')
                                    ->badge()
                                    ->color('info')
                                    ->placeholder('Persyaratan'),
                                Infolists\Components\TextEntry::make('nama_file')
                                    ->label('Nama File Asli'),
                                Infolists\Components\TextEntry::make('path')
                                    ->label('Aksi')
                                    ->formatStateUsing(fn () => 'Buka / Unduh Berkas')
                                    ->url(fn ($state) => asset('storage/' . $state))
                                    ->openUrlInNewTab()
                                    ->color('primary')
                                    ->weight('bold'),
                            ])
                            ->columns(3)
                            ->columnSpanFull()
                            ->placeholder('Tidak ada berkas yang diunggah pemohon.'),
                    ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
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
