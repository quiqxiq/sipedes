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
        return Auth::user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Wilayah Desa')
                    ->schema([
                        Forms\Components\TextInput::make('nama_desa')->label('Nama Desa')->required(),
                        Forms\Components\TextInput::make('kepala_desa')->label('Nama Kepala Desa')->required(),
                        Forms\Components\TextInput::make('kecamatan')->label('Kecamatan')->required(),
                        Forms\Components\TextInput::make('kabupaten')->label('Kabupaten/Kota')->required(),
                        Forms\Components\TextInput::make('provinsi')->label('Provinsi')->required(),
                        Forms\Components\TextInput::make('kode_pos')->label('Kode Pos')->required(),
                    ])->columns(2),

                Section::make('Profil & Keterangan')
                    ->schema([
                        Forms\Components\Textarea::make('sejarah')->label('Sejarah & Gambaran Desa')->rows(4),
                        Forms\Components\Textarea::make('visi_misi')->label('Visi & Misi Desa')->rows(5),
                        Forms\Components\KeyValue::make('potensi_desa')
                            ->label('Potensi Unggulan Desa (pertanian, peternakan, umkm, bumdes)')
                            ->keyLabel('Sektor Potensi')
                            ->valueLabel('Deskripsi'),
                    ]),

                Section::make('Kontak & Jam Operasional')
                    ->schema([
                        Forms\Components\KeyValue::make('kontak')
                            ->label('Kontak Resmi (telepon, whatsapp, email, alamat_kantor)')
                            ->keyLabel('Jenis Kontak')
                            ->valueLabel('Detail'),

                        Forms\Components\KeyValue::make('jam_operasional')
                            ->label('Jam Operasional Kantor')
                            ->keyLabel('Hari')
                            ->valueLabel('Jam Kerja'),

                        Forms\Components\KeyValue::make('statistik')
                            ->label('Data Statistik Publik')
                            ->keyLabel('Keterangan')
                            ->valueLabel('Jumlah'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_desa')->label('Nama Desa')->weight('bold'),
                Tables\Columns\TextColumn::make('kecamatan')->label('Kecamatan'),
                Tables\Columns\TextColumn::make('kabupaten')->label('Kabupaten'),
                Tables\Columns\TextColumn::make('provinsi')->label('Provinsi'),
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
