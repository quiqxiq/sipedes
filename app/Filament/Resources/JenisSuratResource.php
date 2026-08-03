<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisSuratResource\Pages;
use App\Models\JenisSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class JenisSuratResource extends Resource
{
    protected static ?string $model = JenisSurat::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Jenis Surat';

    protected static ?string $modelLabel = 'Jenis Surat';

    protected static ?string $pluralModelLabel = 'Jenis Surat';

    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Jenis Surat')
                    ->schema([
                        Forms\Components\TextInput::make('kode')
                            ->label('Kode Surat')
                            ->placeholder('misal: SKTM, SKU, SKD')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),

                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Jenis Surat')
                            ->placeholder('misal: Surat Keterangan Tidak Mampu (SKTM)')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('estimasi_waktu')
                            ->label('Estimasi Waktu Penyelesaian')
                            ->default('1-3 Hari Kerja')
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->inline(false),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi & Peruntukan')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TagsInput::make('syarat')
                            ->label('Daftar Syarat Berkas Persyaratan')
                            ->placeholder('Ketik nama syarat (misal: Fotokopi KTP) lalu tekan Enter')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->label('Kode')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Jenis Surat')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('estimasi_waktu')
                    ->label('Estimasi Waktu')
                    ->sortable(),

                Tables\Columns\TagsColumn::make('syarat')
                    ->label('Daftar Syarat'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJenisSurats::route('/'),
            'create' => Pages\CreateJenisSurat::route('/create'),
            'edit' => Pages\EditJenisSurat::route('/{record}/edit'),
        ];
    }
}
