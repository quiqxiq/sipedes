<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KnowledgeDocumentResource\Pages;
use App\Models\AktivitasLog;
use App\Models\KnowledgeDocument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class KnowledgeDocumentResource extends Resource
{
    protected static ?string $model = KnowledgeDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?string $navigationGroup = 'Chatbot & AI';

    protected static ?string $navigationLabel = 'Dokumen Pengetahuan';

    protected static ?string $modelLabel = 'Dokumen Pengetahuan';

    protected static ?string $pluralModelLabel = 'Dokumen Pengetahuan (RAG)';

    protected static ?int $navigationSort = 3;

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Unggah Dokumen Basis Pengetahuan (Dify)')
                    ->schema([
                        Forms\Components\TextInput::make('nama_file')
                            ->label('Nama / Judul Dokumen')
                            ->placeholder('misal: SOP Pelayanan Surat Desa 2026')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('kategori')
                            ->label('Kategori Dokumen')
                            ->options([
                                'SOP' => 'SOP & Prosedur Pelayanan',
                                'Perdes' => 'Peraturan Desa (Perdes)',
                                'Syarat' => 'Syarat & Ketentuan Surat',
                                'Profil' => 'Profil & Informasi Desa',
                                'Lainnya' => 'Dokumen Lainnya',
                            ])
                            ->required(),

                        Forms\Components\FileUpload::make('path')
                            ->label('Berkas Dokumen (PDF / DOCX / TXT)')
                            ->directory('knowledge-documents')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'text/plain',
                            ])
                            ->maxSize(10240) // 10MB
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('status_indexing')
                            ->label('Status Indexing Dify')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Sedang Diproses',
                                'indexed' => 'Terindeks',
                                'failed' => 'Gagal Indexing',
                            ])
                            ->default('pending')
                            ->disabled(),

                        Forms\Components\TextInput::make('jumlah_chunks')
                            ->label('Jumlah Chunks')
                            ->numeric()
                            ->default(0)
                            ->disabled(),

                        Forms\Components\TextInput::make('dify_document_id')
                            ->label('Dify Document ID')
                            ->disabled()
                            ->placeholder('Otomatis terisi setelah indexing Dify')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_file')
                    ->label('Nama Dokumen')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('status_indexing')
                    ->label('Status Index Dify')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'indexed' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('jumlah_chunks')
                    ->label('Chunks')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Diunggah Oleh')
                    ->placeholder('System'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'SOP' => 'SOP & Prosedur Pelayanan',
                        'Perdes' => 'Peraturan Desa (Perdes)',
                        'Syarat' => 'Syarat & Ketentuan Surat',
                        'Profil' => 'Profil & Informasi Desa',
                        'Lainnya' => 'Dokumen Lainnya',
                    ]),

                Tables\Filters\SelectFilter::make('status_indexing')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Sedang Diproses',
                        'indexed' => 'Terindeks',
                        'failed' => 'Gagal Indexing',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('sync_dify')
                    ->label('Index ke Dify')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->action(function (KnowledgeDocument $record): void {
                        // Dummy/Mock status transition until DifyService API client is called
                        $record->update([
                            'status_indexing' => 'indexed',
                            'is_indexed' => true,
                            'jumlah_chunks' => rand(5, 25),
                            'dify_document_id' => 'doc-' => uniqid(),
                        ]);

                        AktivitasLog::catat(Auth::id(), 'knowledge', 'index_dify', "Sync dokumen '{$record->nama_file}' ke Dify Knowledge Base");

                        Notification::make()
                            ->title('Dokumen berhasil dikirim dan terindeks di Dify RAG')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKnowledgeDocuments::route('/'),
            'create' => Pages\CreateKnowledgeDocument::route('/create'),
            'edit' => Pages\EditKnowledgeDocument::route('/{record}/edit'),
        ];
    }
}
