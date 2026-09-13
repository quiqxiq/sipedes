<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramBantuanResource\Pages;
use App\Models\ProgramBantuan;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ProgramBantuanResource extends Resource
{
    protected static ?string $model = ProgramBantuan::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-gift';

    protected static string|\UnitEnum|null $navigationGroup = 'Informasi Publik';

    protected static ?string $navigationLabel = 'Bantuan Sosial & Kesejahteraan';

    protected static ?string $modelLabel = 'Program Bantuan';

    protected static ?string $pluralModelLabel = 'Program Bantuan Sosial';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Program Bantuan Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('nama_program')
                            ->label('Nama Program Bantuan')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('kategori')
                            ->label('Kategori Bantuan')
                            ->options([
                                'pkh' => 'Program Keluarga Harapan (PKH)',
                                'bansos_lansia' => 'Bansos Lansia & Disabilitas',
                                'blt_dana_desa' => 'BLT Dana Desa (BLT-DD)',
                                'beras_cbp' => 'Bantuan Beras CBP (10 Kg)',
                                'bpnt_sembako' => 'BPNT / Program Sembako',
                                'pertanian_pupuk' => 'Bantuan Pertanian & Pupuk Subsidi',
                                'kesehatan_stunting' => 'PMT Gizi & Stunting Balita',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('sumber_dana')
                            ->label('Sumber Dana')
                            ->placeholder('Contoh: Dana Desa (APBDes) TA 2026 / Kemensos RI')
                            ->required(),

                        Forms\Components\TextInput::make('besaran_bantuan')
                            ->label('Besaran / Bentuk Bantuan')
                            ->placeholder('Contoh: 10 kg beras bulog atau Rp 300.000 / bulan')
                            ->required(),

                        Forms\Components\TextInput::make('kuota_penerima')
                            ->label('Kuota / Target KPM')
                            ->numeric()
                            ->nullable(),

                        Forms\Components\TextInput::make('penanggung_jawab')
                            ->label('Pamong / Petugas Penanggung Jawab')
                            ->placeholder('Contoh: Zainal Abidin (Kasi Kesra) & 5 Kepala Dusun'),

                        Forms\Components\TextInput::make('tahun_anggaran')
                            ->label('Tahun Anggaran')
                            ->default(2026)
                            ->numeric()
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Status Penyaluran')
                            ->options([
                                'dibuka' => 'Pendaftaran / Verifikasi',
                                'proses_seleksi' => 'Proses Penetapan KPM',
                                'penyaluran' => 'Sedang Disalurkan',
                                'selesai' => 'Selesai Penyaluran',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('kriteria_penerima')
                            ->label('Kriteria Penerima Manfaat')
                            ->rows(3)
                            ->columnSpanFull()
                            ->required(),

                        Forms\Components\TagsInput::make('syarat_dokumen')
                            ->label('Persyaratan Dokumen Saat Pengambilan')
                            ->placeholder('Tambah syarat (KTP asli, KK, dll)...')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('foto_pengumuman')
                            ->label('Foto / Scan Lembar Pengumuman Daftar Penerima')
                            ->helperText('Upload foto scan daftar KPM atau poster pengumuman dari pamong desa')
                            ->image()
                            ->multiple()
                            ->directory('bansos')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan & Lokasi Pengambilan di Balai Desa')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_program')
                    ->label('Nama Program')
                    ->searchable()
                    ->weight('bold')
                    ->limit(35),

                Tables\Columns\TextColumn::make('kategori_label')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('besaran_bantuan')
                    ->label('Bentuk Bantuan'),

                Tables\Columns\TextColumn::make('kuota_penerima')
                    ->label('Target KPM')
                    ->formatStateUsing(fn ($state) => $state ? $state . ' KPM' : '-'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'dibuka' => 'info',
                        'proses_seleksi' => 'warning',
                        'penyaluran' => 'success',
                        'selesai' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('tahun_anggaran')
                    ->label('Tahun')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'pkh' => 'Program Keluarga Harapan (PKH)',
                        'bansos_lansia' => 'Bansos Lansia & Disabilitas',
                        'blt_dana_desa' => 'BLT Dana Desa (BLT-DD)',
                        'beras_cbp' => 'Bantuan Beras CBP (10 Kg)',
                        'bpnt_sembako' => 'BPNT / Program Sembako',
                        'pertanian_pupuk' => 'Bantuan Pertanian & Pupuk Subsidi',
                        'kesehatan_stunting' => 'PMT Gizi & Stunting Balita',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'dibuka' => 'Pendaftaran / Verifikasi',
                        'proses_seleksi' => 'Proses Penetapan',
                        'penyaluran' => 'Sedang Disalurkan',
                        'selesai' => 'Selesai',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProgramBantuans::route('/'),
            'create' => Pages\CreateProgramBantuan::route('/create'),
            'edit' => Pages\EditProgramBantuan::route('/{record}/edit'),
        ];
    }
}
