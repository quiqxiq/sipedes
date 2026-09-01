<?php

namespace App\Filament\Resources\KnowledgeDocumentResource\Pages;

use App\Filament\Resources\KnowledgeDocumentResource;
use App\Services\DifyService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditKnowledgeDocument extends EditRecord
{
    protected static string $resource = KnowledgeDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function (\App\Models\KnowledgeDocument $record): void {
                    if (filled($record->dify_document_id)) {
                        app(DifyService::class)->deleteDocument($record->dify_document_id);
                    }
                }),
        ];
    }

    protected function afterSave(): void
    {
        /** @var \App\Models\KnowledgeDocument $record */
        $record = $this->record;
        $dify = app(DifyService::class);

        if (! $dify->isKnowledgeConfigured()) {
            return;
        }

        $newPath = $this->data['path'] ?? $record->path;
        $oldPath = $record->getOriginal('path');

        // File tidak diubah dan dokumen sudah terindex di Dify → tidak perlu re-upload.
        if ($newPath === $oldPath && filled($record->dify_document_id)) {
            return;
        }

        $filePath = $dify->resolveStoredFilePath($record->path);

        if (! $filePath) {
            return;
        }

        $fileName = DifyService::buildDocumentName($record->nama_file, pathinfo($record->path, PATHINFO_EXTENSION));

        $result = $dify->uploadDocument($filePath, $fileName);

        if ($result['success']) {
            // Hanya hapus dokumen lama di Dify setelah dokumen baru berhasil ter-upload,
            // agar jika upload gagal, dokumen lama tetap tersedia di knowledge base.
            if (filled($record->dify_document_id)) {
                $dify->deleteDocument($record->dify_document_id);
            }

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
                ->title('Gagal upload ulang ke Dify')
                ->body($result['message'] ?? 'Terjadi kesalahan saat menghubungi Dify.')
                ->warning()
                ->send();
        }
    }
}
