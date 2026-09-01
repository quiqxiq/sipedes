<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KnowledgeDocumentResource\Pages;
use App\Models\AktivitasLog;
use App\Models\KnowledgeDocument;
use App\Services\DifyService;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class KnowledgeDocumentResource extends Resource
{
    protected static ?string $model = KnowledgeDocument::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cpu-chip';

    protected static string|\UnitEnum|null $navigationGroup = 'Chatbot & AI';

    protected static ?string $navigationLabel = 'Dokumen Pengetahuan';

    protected static ?string $modelLabel = 'Dokumen Pengetahuan';

    protected static ?string $pluralModelLabel = 'Dokumen Pengetahuan (RAG)';

    protected static ?int $navigationSort = 3;

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Unggah Dokumen Basis Pengetahuan (Dify)')
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
                Actions\EditAction::make(),

                Actions\Action::make('sync_dify')
                    ->label('Index ke Dify')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading('Index dokumen ke Dify?')
                    ->modalDescription('File akan diunggah ke Knowledge Base Dify untuk diproses (chunking & indexing).')
                    ->action(function (KnowledgeDocument $record): void {
                        $dify = app(DifyService::class);

                        if (filled($record->dify_document_id)) {
                            Notification::make()
                                ->title('Dokumen sudah pernah di-index ke Dify')
                                ->body('Gunakan aksi "Cek Status" untuk melihat status indexing terkini.')
                                ->info()
                                ->send();

                            return;
                        }

                        if (! $dify->isKnowledgeConfigured()) {
                            Notification::make()
                                ->title('Konfigurasi Dify belum lengkap')
                                ->body('Periksa DIFY_KNOWLEDGE_API_KEY dan DIFY_DATASET_ID di file .env.')
                                ->danger()
                                ->send();

                            return;
                        }

                        $filePath = $dify->resolveStoredFilePath($record->path);

                        if (! $filePath) {
                            Notification::make()
                                ->title('File dokumen tidak ditemukan')
                                ->body('File tidak ada di storage, tidak dapat di-upload ke Dify.')
                                ->warning()
                                ->send();

                            return;
                        }

                        $fileName = DifyService::buildDocumentName($record->nama_file, pathinfo($record->path, PATHINFO_EXTENSION));

                        $result = $dify->uploadDocument($filePath, $fileName);

                        if (! $result['success']) {
                            Notification::make()
                                ->title('Gagal upload ke Dify')
                                ->body($result['message'] ?? 'Terjadi kesalahan saat menghubungi Dify.')
                                ->danger()
                                ->send();

                            return;
                        }

                        $record->update([
                            'dify_document_id' => $result['document_id'],
                            'status_indexing' => $result['indexing_status'] ?? 'processing',
                            'is_indexed' => ($result['indexing_status'] ?? '') === 'completed',
                        ]);

                        AktivitasLog::catat(Auth::id(), 'knowledge', 'index_dify', "Upload dokumen '{$record->nama_file}' ke Dify Knowledge Base");

                        Notification::make()
                            ->title('Dokumen berhasil dikirim ke Dify')
                            ->body('Status indexing: ' . ($result['indexing_status'] ?? 'processing'))
                            ->success()
                            ->send();
                    }),

                Actions\Action::make('cek_status')
                    ->label('Cek Status')
                    ->icon('heroicon-o-arrow-path')
                    ->color('gray')
                    ->visible(fn (KnowledgeDocument $record): bool => filled($record->dify_document_id))
                    ->action(function (KnowledgeDocument $record): void {
                        $dify = app(DifyService::class);

                        $result = $dify->getIndexingStatus($record->dify_document_id);

                        if (! $result['success']) {
                            Notification::make()
                                ->title('Gagal mengambil status')
                                ->body($result['message'] ?? 'Terjadi kesalahan saat menghubungi Dify.')
                                ->danger()
                                ->send();

                            return;
                        }

                        $status = $result['status'] ?? $record->status_indexing;

                        $record->update([
                            'status_indexing' => $status,
                            'jumlah_chunks' => $result['completed_segments'] ?? $record->jumlah_chunks,
                            'is_indexed' => $status === 'completed',
                        ]);

                        $statusLabel = match ($status) {
                            'completed' => 'Terindeks',
                            'indexing', 'parsing', 'cleaning', 'splitting' => 'Sedang Diproses',
                            'error' => 'Gagal Indexing',
                            default => ucfirst($status),
                        };

                        Notification::make()
                            ->title("Status Indexing: {$statusLabel}")
                            ->body(filled($result['completed_segments']) ? "Segmen terindeks: {$result['completed_segments']}" : null)
                            ->success()
                            ->send();
                    }),

                Actions\DeleteAction::make()
                    ->after(function (KnowledgeDocument $record): void {
                        if (filled($record->dify_document_id)) {
                            app(DifyService::class)->deleteDocument($record->dify_document_id);
                        }
                    }),
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
