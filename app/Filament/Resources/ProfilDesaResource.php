<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfilDesaResource\Pages;
use App\Models\ProfilDesa;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ProfilDesaResource extends Resource
{
    protected static ?string $model = ProfilDesa::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-library';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Profil Desa';

    protected static ?string $modelLabel = 'Profil Desa';

    protected static ?string $pluralModelLabel = 'Profil Desa';

    protected static ?int $navigationSort = 6;

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->isAdmin() || $user->isPetugas());
    }

    public static function canCreate(): bool
    {
        return ProfilDesa::count() === 0;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Wilayah & Kepemimpinan Desa')
                    ->description('Data identitas utama desa dan kepala desa yang memimpin.')
                    ->schema([
                        Forms\Components\TextInput::make('nama_desa')
                            ->label('Nama Desa')
                            ->placeholder('misal: Rombiya Barat')
                            ->required(),
                        Forms\Components\TextInput::make('kepala_desa')
                            ->label('Nama Kepala Desa')
                            ->placeholder('misal: Farhah')
                            ->required(),
                        Forms\Components\TextInput::make('kecamatan')
                            ->label('Kecamatan')
                            ->placeholder('misal: Ganding')
                            ->required(),
                        Forms\Components\TextInput::make('kabupaten')
                            ->label('Kabupaten / Kota')
                            ->placeholder('misal: Sumenep')
                            ->required(),
                        Forms\Components\TextInput::make('provinsi')
                            ->label('Provinsi')
                            ->placeholder('misal: Jawa Timur')
                            ->required(),
                        Forms\Components\TextInput::make('kode_pos')
                            ->label('Kode Pos')
                            ->placeholder('misal: 69462')
                            ->required(),
                    ])->columns(2),

                Section::make('Sejarah, Profil & Visi-Misi Desa')
                    ->description('Narasi sejarah desa serta visi dan misi pembangunan desa.')
                    ->schema([
                        Forms\Components\Textarea::make('sejarah')
                            ->label('Sejarah & Gambaran Singkat Desa')
                            ->placeholder('Ceritakan sejarah berdirinya desa, letak geografis, serta kearifan lokal...')
                            ->rows(5)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('visi_misi')
                            ->label('Visi & Misi Desa')
                            ->placeholder("VISI:\nTerwujudnya tata kelola...\n\nMISI:\n1. Menyelenggarakan...")
                            ->rows(8)
                            ->columnSpanFull(),
                    ]),

                Section::make('Daftar Wilayah Kewilayahan Dusun')
                    ->description('Kelola daftar dusun, kepala dusun, jumlah RT, dan potensi wilayah tiap dusun.')
                    ->schema([
                        Forms\Components\Repeater::make('dusun_list')
                            ->label('Daftar Dusun')
                            ->addActionLabel('+ Tambah Dusun Baru')
                            ->schema([
                                Forms\Components\TextInput::make('nama')
                                    ->label('Nama Dusun')
                                    ->placeholder('Contoh: Dusun Kebunan')
                                    ->required(),
                                Forms\Components\TextInput::make('kasun')
                                    ->label('Nama Kepala Dusun (Kasun)')
                                    ->placeholder('Contoh: Kasun Kebunan'),
                                Forms\Components\TextInput::make('jumlah_rt')
                                    ->label('Jumlah RT')
                                    ->numeric()
                                    ->default(3),
                                Forms\Components\TextInput::make('deskripsi')
                                    ->label('Deskripsi / Potensi Unggulan Dusun')
                                    ->placeholder('Contoh: Sentra pertanian tanaman pangan dan perkebunan tembakau')
                                    ->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->collapsible()
                            ->columnSpanFull(),
                    ]),

                Section::make('Potensi Unggulan Desa')
                    ->description('Komoditas dan sektor unggulan desa (pertanian, peternakan, UMKM, BUMDes, dll).')
                    ->schema([
                        Forms\Components\KeyValue::make('potensi_desa')
                            ->label('Sektor Potensi & Komoditas Unggulan')
                            ->keyLabel('Sektor (contoh: pertanian, peternakan, umkm, bumdes)')
                            ->valueLabel('Deskripsi / Penjelasan Komoditas & Usaha')
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Data Statistik Publik & Kependudukan')
                    ->description('Data kependudukan resmi yang ditampilkan pada grafik & kartu statistik di Landing Page.')
                    ->schema([
                        Forms\Components\KeyValue::make('statistik')
                            ->label('Statistik Kependudukan & Publik')
                            ->keyLabel('Parameter (jumlah_penduduk, jumlah_penduduk_max, jumlah_laki_laki, jumlah_perempuan, jumlah_kk, sumber_data)')
                            ->valueLabel('Nilai / Keterangan')
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Kontak Resmi & Jam Operasional Pelayanan')
                    ->description('Alamat kantor balai desa, nomor kontak layanan warga, dan jam kerja tatap muka.')
                    ->schema([
                        Forms\Components\KeyValue::make('kontak')
                            ->label('Kontak Resmi Balai Desa')
                            ->keyLabel('Jenis Kontak (telepon, whatsapp, email, alamat_kantor)')
                            ->valueLabel('Detail / Nilai Kontak')
                            ->columnSpanFull(),

                        Forms\Components\KeyValue::make('jam_operasional')
                            ->label('Jam Operasional Pelayanan Tatap Muka')
                            ->keyLabel('Hari (misal: Senin - Kamis, Jumat, Sabtu - Minggu)')
                            ->valueLabel('Jam Kerja (misal: 08:00 - 15:00 WIB)')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_desa')->label('Nama Desa')->weight('bold'),
                Tables\Columns\TextColumn::make('kepala_desa')->label('Kepala Desa'),
                Tables\Columns\TextColumn::make('kecamatan')->label('Kecamatan'),
                Tables\Columns\TextColumn::make('kabupaten')->label('Kabupaten'),
                Tables\Columns\TextColumn::make('updated_at')->label('Terakhir Diperbarui')->dateTime('d M Y H:i'),
            ])
            ->actions([
                Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfilDesas::route('/'),
            'edit' => Pages\EditProfilDesa::route('/{record}/edit'),
        ];
    }
}
