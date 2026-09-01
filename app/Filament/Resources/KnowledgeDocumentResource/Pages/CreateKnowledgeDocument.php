<?php

namespace App\Filament\Resources\KnowledgeDocumentResource\Pages;

use App\Filament\Resources\KnowledgeDocumentResource;
use App\Services\DifyService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateKnowledgeDocument extends CreateRecord
{
    protected static string $resource = KnowledgeDocumentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }

    protected function afterCreate(): void
    {
        /** @var \App\Models\KnowledgeDocument $record */
        $record = $this->record;
        $dify = app(DifyService::class);

        if (! $dify->isKnowledgeConfigured()) {
            Notification::make()
                ->title('Dokumen disimpan, tetapi Dify belum dikonfigurasi')
                ->body('Periksa DIFY_KNOWLEDGE_API_KEY dan DIFY_DATASET_ID di file .env.')
                ->warning()
                ->send();

            return;
        }

        $filePath = $dify->resolveStoredFilePath($record->path);

        if (! $filePath) {
            return;
        }

        $fileName = DifyService::buildDocumentName($record->nama_file, pathinfo($record->path, PATHINFO_EXTENSION));

        $result = $dify->uploadDocument($filePath, $fileName);

        if ($result['success']) {
            $record->update([
                'dify_document_id' => $result['document_id'],
                'status_indexing' => $result['indexing_status'] ?? 'processing',
                'is_indexed' => ($result['indexing_status'] ?? '') === 'completed',
            ]);

            Notification::make()
                ->title('Dokumen terkirim ke Dify')
                ->body('Status indexing: ' . ($result['indexing_status'] ?? 'processing'))
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Dokumen tersimpan, tetapi gagal upload ke Dify')
                ->body($result['message'] ?? 'Terjadi kesalahan saat menghubungi Dify.')
                ->warning()
                ->send();
        }
    }
}
