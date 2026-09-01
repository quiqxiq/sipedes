<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeritaResource\Pages;
use App\Models\Berita;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    protected static string|\UnitEnum|null $navigationGroup = 'Informasi Publik';

    protected static ?string $navigationLabel = 'Warta & Pengumuman';

    protected static ?string $modelLabel = 'Warta Desa';

    protected static ?string $pluralModelLabel = 'Warta & Pengumuman Desa';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Konten Warta & Pengumuman')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Berita / Agenda')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('kategori')
                            ->label('Kategori')
                            ->options([
                                'berita' => 'Berita Desa',
                                'pengumuman' => 'Pengumuman Resmi',
                                'agenda' => 'Agenda / Musdes',
                                'posyandu' => 'Jadwal Posyandu 5 Dusun',
                                'bumdes' => 'BUMDes Kencana',
                            ])
                            ->required(),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->default(now()),

                        Forms\Components\Textarea::make('ringkasan')
                            ->label('Ringkasan Singkat')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('konten')
                            ->label('Isi Lengkap')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('gambar_cover')
                            ->label('Gambar Cover / Foto Dokumentasi')
                            ->image()
                            ->directory('berita')
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Tayangkan ke Publik')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->limit(40)
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('kategori_label')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (Berita $record) => match ($record->kategori) {
                        'berita' => 'info',
                        'pengumuman' => 'danger',
                        'agenda' => 'warning',
                        'posyandu' => 'success',
                        'bumdes' => 'primary',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Tayang')
                    ->boolean(),

                Tables\Columns\TextColumn::make('views')
                    ->label('Dilihat')
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'berita' => 'Berita Desa',
                        'pengumuman' => 'Pengumuman Resmi',
                        'agenda' => 'Agenda / Musdes',
                        'posyandu' => 'Jadwal Posyandu',
                        'bumdes' => 'BUMDes Kencana',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
        ];
    }
}
