<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenerimaBantuanResource\Pages;
use App\Models\PenerimaBantuan;
use App\Models\ProgramBantuan;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PenerimaBantuanResource extends Resource
{
    protected static ?string $model = PenerimaBantuan::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|\UnitEnum|null $navigationGroup = 'Informasi Publik';

    protected static ?string $navigationLabel = 'Data Penerima Bansos (KPM)';

    protected static ?string $modelLabel = 'Penerima Bansos';

    protected static ?string $pluralModelLabel = 'Data Penerima Bansos (KPM)';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Identitas Warga Penerima (KPM)')
                    ->schema([
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK (16 Digit)')
                            ->required()
                            ->maxLength(16)
                            ->minLength(16)
                            ->placeholder('Contoh: 3529012304950001'),

                        Forms\Components\TextInput::make('nama_penerima')
                            ->label('Nama Lengkap Penerima')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('dusun')
                            ->label('Dusun Domisili')
                            ->options([
                                'Dusun Kebunan' => 'Dusun Kebunan',
                                'Dusun Buwa' => 'Dusun Buwa',
                                'Dusun Tanodung' => 'Dusun Tanodung',
                                'Dusun Rombiya' => 'Dusun Rombiya',
                                'Dusun Kalampok' => 'Dusun Kalampok',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('alamat_detail')
                            ->label('Alamat / RT / RW')
                            ->placeholder('Contoh: RT 002 RW 001 Dusun Kebunan'),
                    ])->columns(2),

                Section::make('Rincian Program & Bantuan yang Diterima')
                    ->schema([
                        Forms\Components\Select::make('program_bantuan_id')
                            ->label('Program Bantuan Terkait')
                            ->relationship('programBantuan', 'nama_program')
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Forms\Components\TextInput::make('jenis_bansos')
                            ->label('Jenis Program Bansos')
                            ->placeholder('Contoh: Bantuan Cadangan Beras Pemerintah (CBP 10 Kg)')
                            ->required(),

                        Forms\Components\TextInput::make('rincian_yang_diterima')
                            ->label('Rincian Apa Saja yang Diterima')
                            ->placeholder('Contoh: 10 Kg Beras Medium Bulog + Minyak Goreng 2L')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('periode')
                            ->label('Periode Penyaluran')
                            ->placeholder('Contoh: Tahap 1 - 2026 (Maret 2026)')
                            ->required(),

                        Forms\Components\Select::make('status_penyaluran')
                            ->label('Status Penyaluran')
                            ->options([
                                'terdaftar' => 'Terdaftar sebagai KPM',
                                'siap_diambil' => 'Siap Diambil di Balai Desa',
                                'sudah_diterima' => 'Sudah Diterima',
                                'dibatalkan' => 'Dibatalkan',
                            ])
                            ->default('terdaftar')
                            ->required(),

                        Forms\Components\DatePicker::make('tanggal_penyaluran')
                            ->label('Tanggal Penyaluran / Pengambilan')
                            ->nullable(),

                        Forms\Components\TextInput::make('lokasi_pengambilan')
                            ->label('Lokasi Pengambilan / Penyerahan')
                            ->default('Kantor Balai Desa Rombiya Barat')
                            ->required(),

                        Forms\Components\FileUpload::make('foto_dokumen_daftar')
                            ->label('Foto / Scan Dokumen Daftar Penerima dari Pamong')
                            ->helperText('Unggah foto lembar scan bukti daftar penerima atau tanda terima')
                            ->image()
                            ->directory('bansos/penerima')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan & Petunjuk Pengambilan')
                            ->placeholder('Contoh: Bawa KTP dan KK asli saat datang ke Balai Desa.')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_penerima')
                    ->label('Nama KPM')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('nik_masked')
                    ->label('NIK')
                    ->fontFamily('mono')
                    ->searchable(query: fn ($query, $search) => $query->where('nik', 'like', "%{$search}%")),

                Tables\Columns\TextColumn::make('dusun')
                    ->label('Dusun')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenis_bansos')
                    ->label('Jenis Bansos')
                    ->searchable()
                    ->limit(25),

                Tables\Columns\TextColumn::make('rincian_yang_diterima')
                    ->label('Rincian yang Diterima')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('periode')
                    ->label('Periode')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status_penyaluran')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'terdaftar' => 'info',
                        'siap_diambil' => 'warning',
                        'sudah_diterima' => 'success',
                        'dibatalkan' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'terdaftar' => 'Terdaftar',
                        'siap_diambil' => 'Siap Diambil',
                        'sudah_diterima' => 'Sudah Diterima',
                        'dibatalkan' => 'Dibatalkan',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_penyaluran')
                    ->label('Tgl Penyaluran')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('dusun')
                    ->label('Filter Dusun')
                    ->options([
                        'Dusun Kebunan' => 'Dusun Kebunan',
                        'Dusun Buwa' => 'Dusun Buwa',
                        'Dusun Tanodung' => 'Dusun Tanodung',
                        'Dusun Rombiya' => 'Dusun Rombiya',
                        'Dusun Kalampok' => 'Dusun Kalampok',
                    ]),

                Tables\Filters\SelectFilter::make('status_penyaluran')
                    ->label('Filter Status')
                    ->options([
                        'terdaftar' => 'Terdaftar',
                        'siap_diambil' => 'Siap Diambil',
                        'sudah_diterima' => 'Sudah Diterima',
                        'dibatalkan' => 'Dibatalkan',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenerimaBantuans::route('/'),
            'create' => Pages\CreatePenerimaBantuan::route('/create'),
            'edit' => Pages\EditPenerimaBantuan::route('/{record}/edit'),
        ];
    }
}
