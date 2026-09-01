<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerangkatDesaResource\Pages;
use App\Models\PerangkatDesa;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PerangkatDesaResource extends Resource
{
    protected static ?string $model = PerangkatDesa::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Pamong / Perangkat Desa';

    protected static ?string $modelLabel = 'Perangkat Desa';

    protected static ?string $pluralModelLabel = 'Pamong & Perangkat Desa';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Data Pamong / Perangkat Desa')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Lengkap & Gelar')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('jabatan')
                            ->label('Jabatan Pemerintahan Desa')
                            ->placeholder('Contoh: Kepala Desa, Sekretaris Desa, Kasun Kebunan')
                            ->required(),

                        Forms\Components\TextInput::make('wilayah_tugas')
                            ->label('Wilayah Penugasan')
                            ->placeholder('Contoh: Dusun Kebunan atau Kantor Balai Desa'),

                        Forms\Components\TextInput::make('nip_atau_nomor')
                            ->label('NIP / Nomor SK / NIK')
                            ->placeholder('Nomor Induk Pegawai / NIK'),

                        Forms\Components\TextInput::make('telepon')
                            ->label('Nomor WhatsApp / HP')
                            ->tel(),

                        Forms\Components\TextInput::make('urutan')
                            ->label('Urutan Tampilan Struktur')
                            ->numeric()
                            ->default(1),

                        Forms\Components\FileUpload::make('foto')
                            ->label('Foto Resmi Perangkat Desa')
                            ->image()
                            ->directory('perangkat-desa')
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Menjabat Aktif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('urutan')
                    ->label('#')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Pamong')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('wilayah_tugas')
                    ->label('Wilayah Tugas')
                    ->searchable(),

                Tables\Columns\TextColumn::make('telepon')
                    ->label('Kontak'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('urutan')
            ->actions([
                Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPerangkatDesas::route('/'),
            'create' => Pages\CreatePerangkatDesa::route('/create'),
            'edit' => Pages\EditPerangkatDesa::route('/{record}/edit'),
        ];
    }
}
