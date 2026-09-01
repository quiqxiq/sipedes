<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengaduanResource\Pages;
use App\Models\AktivitasLog;
use App\Models\Pengaduan;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PengaduanResource extends Resource
{
    protected static ?string $model = Pengaduan::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|\UnitEnum|null $navigationGroup = 'Layanan Desa';

    protected static ?string $navigationLabel = 'Aspirasi & Pengaduan';

    protected static ?string $modelLabel = 'Pengaduan Warga';

    protected static ?string $pluralModelLabel = 'Aspirasi & Pengaduan Warga';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Tiket Pengaduan')
                    ->schema([
                        Forms\Components\TextInput::make('kode_tiket')
                            ->label('Kode Tiket')
                            ->readOnly(),

                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Warga Pelapor')
                            ->disabled(),

                        Forms\Components\Select::make('dusun')
                            ->label('Lokasi Dusun')
                            ->options([
                                'Dusun Kebunan' => 'Dusun Kebunan',
                                'Dusun Buwa' => 'Dusun Buwa',
                                'Dusun Tanodung' => 'Dusun Tanodung',
                                'Dusun Rombiya' => 'Dusun Rombiya',
                                'Dusun Kalampok' => 'Dusun Kalampok',
                            ])
                            ->required(),

                        Forms\Components\Select::make('kategori')
                            ->label('Kategori Masalah')
                            ->options([
                                'pertanian_irigasi' => 'Pertanian & Irigasi / Pupuk',
                                'jalan_infrastruktur' => 'Jalan & Infrastruktur Dusun',
                                'bansos' => 'Bantuan Sosial & Kesejahteraan',
                                'kebersihan_lingkungan' => 'Kebersihan & Lingkungan',
                                'pelayanan_desa' => 'Pelayanan Balai Desa',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Pengaduan')
                            ->columnSpanFull()
                            ->required(),

                        Forms\Components\TextInput::make('lokasi_detail')
                            ->label('Detail Titik Lokasi')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Isi Laporan / Keluhan')
                            ->rows(4)
                            ->columnSpanFull()
                            ->required(),

                        Forms\Components\FileUpload::make('foto_lampiran')
                            ->label('Foto Bukti Lapangan')
                            ->image()
                            ->directory('pengaduan')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Tindak Lanjut & Tanggapan Balai Desa')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status Laporan')
                            ->options([
                                'menunggu' => 'Menunggu Verifikasi',
                                'diproses' => 'Sedang Ditindaklanjuti',
                                'selesai' => 'Selesai Ditangani',
                                'ditolak' => 'Ditolak',
                            ])
                            ->required(),

                        Forms\Components\Select::make('petugas_id')
                            ->relationship('petugas', 'name', fn (Builder $query) => $query->whereIn('role', ['petugas', 'admin']))
                            ->label('Petugas Penanggung Jawab')
                            ->default(fn () => Auth::id()),

                        Forms\Components\Textarea::make('tanggapan_petugas')
                            ->label('Tanggapan Resmi Balai Desa / Kasun')
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Tuliskan langkah tindak lanjut atau penjelasan resmi kepada warga...'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_tiket')
                    ->label('Kode Tiket')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Warga')
                    ->searchable(),

                Tables\Columns\TextColumn::make('dusun')
                    ->label('Dusun')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori_label')
                    ->label('Kategori')
                    ->searchable(['kategori']),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Laporan')
                    ->limit(35)
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'menunggu' => 'Menunggu',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'diproses' => 'info',
                        'selesai' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Lapor')
                    ->dateTime('d M Y H:i')
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

                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak',
                    ]),

                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Filter Kategori')
                    ->options([
                        'pertanian_irigasi' => 'Pertanian & Irigasi / Pupuk',
                        'jalan_infrastruktur' => 'Jalan & Infrastruktur Dusun',
                        'bansos' => 'Bantuan Sosial & Kesejahteraan',
                        'kebersihan_lingkungan' => 'Kebersihan & Lingkungan',
                        'pelayanan_desa' => 'Pelayanan Balai Desa',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make()->label('Tindak Lanjut'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengaduans::route('/'),
            'edit' => Pages\EditPengaduan::route('/{record}/edit'),
        ];
    }
}
