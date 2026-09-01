<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan & Sistem';

    protected static ?string $navigationLabel = 'Manajemen Pengguna';

    protected static ?string $modelLabel = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Manajemen Pengguna';

    protected static ?int $navigationSort = 4;

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Akun & Data Diri')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('nik')
                            ->label('NIK (Nomor Induk Kependudukan)')
                            ->placeholder('16 Digit NIK')
                            ->numeric()
                            ->length(16)
                            ->rules(['digits:16'])
                            ->nullable()
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('email')
                            ->label('Alamat Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('telepon')
                            ->label('Nomor Telepon / WhatsApp')
                            ->tel()
                            ->nullable(),

                        Forms\Components\Select::make('role')
                            ->label('Peran (Role)')
                            ->options([
                                'admin' => 'Administrator',
                                'petugas' => 'Petugas Desa',
                                'warga' => 'Warga',
                            ])
                            ->default('warga')
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Akun Aktif')
                            ->default(true)
                            ->inline(false),

                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat Domisili')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('password')
                            ->label('Kata Sandi (Password)')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('telepon')
                    ->label('Telepon/WA')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'petugas' => 'info',
                        'warga' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'Administrator',
                        'petugas' => 'Petugas Desa',
                        'warga' => 'Warga',
                        default => $state,
                    }),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Administrator',
                        'petugas' => 'Petugas Desa',
                        'warga' => 'Warga',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Akun'),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
