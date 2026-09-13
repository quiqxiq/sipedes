<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhatsAppLogResource\Pages;
use App\Models\WhatsAppLog;
use App\Services\WhatsAppService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class WhatsAppLogResource extends Resource
{
    protected static ?string $model = WhatsAppLog::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-queue-list';

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan & Sistem';

    protected static ?string $navigationLabel = 'Log WhatsApp';

    protected static ?string $modelLabel = 'Log Pengiriman WhatsApp';

    protected static ?string $pluralModelLabel = 'Riwayat Log WhatsApp';

    protected static ?int $navigationSort = 5;

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i:s')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nomor_tujuan')
                    ->label('Nomor Tujuan')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Nomor WhatsApp disalin')
                    ->weight('bold')
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('nama_penerima')
                    ->label('Penerima')
                    ->searchable()
                    ->placeholder('Tanpa Nama')
                    ->wrap(),

                Tables\Columns\TextColumn::make('tipe_pesan')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'surat' => 'success',
                        'pengaduan' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'surat' => '📄 Surat',
                        'pengaduan' => '📢 Aduan',
                        default => '⚙️ Sistem',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'sent' => 'success',
                        'failed' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'sent' => '✓ Terkirim',
                        'failed' => '✗ Gagal',
                        'pending' => '⏳ Menunggu',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('pesan')
                    ->label('Ringkasan Pesan')
                    ->limit(55)
                    ->tooltip(fn (WhatsAppLog $record) => $record->pesan),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Pengiriman')
                    ->options([
                        'sent' => 'Terkirim',
                        'failed' => 'Gagal',
                        'pending' => 'Menunggu',
                    ]),

                Tables\Filters\SelectFilter::make('tipe_pesan')
                    ->label('Kategori Pesan')
                    ->options([
                        'surat' => 'Layanan Surat',
                        'pengaduan' => 'Pengaduan',
                        'sistem' => 'Sistem',
                    ]),
            ])
            ->actions([
                Actions\Action::make('lihat')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Rincian Log Pengiriman Pesan WhatsApp')
                    ->modalContent(function (WhatsAppLog $record) {
                        $pesanHtml = nl2br(e($record->pesan));
                        $errorHtml = $record->error_message ? "<div class='p-3 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 rounded-xl text-xs text-rose-700 dark:text-rose-300'><strong>Pesan Galat (Error):</strong><br />" . e($record->error_message) . "</div>" : "";
                        $payloadJson = $record->response_payload ? json_encode($record->response_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : null;
                        $payloadHtml = $payloadJson ? "<div class='mt-2'><span class='text-xs font-semibold text-gray-500'>Response Payload:</span><pre class='p-2 bg-gray-100 dark:bg-gray-800 rounded text-[11px] overflow-x-auto'>{$payloadJson}</pre></div>" : "";

                        return new HtmlString("
                            <div class='space-y-3 text-sm'>
                                <div class='grid grid-cols-2 gap-2 text-xs'>
                                    <div><strong>Nomor:</strong> {$record->nomor_tujuan}</div>
                                    <div><strong>Penerima:</strong> " . e($record->nama_penerima ?? '-') . "</div>
                                    <div><strong>Kategori:</strong> {$record->tipe_pesan}</div>
                                    <div><strong>Waktu Kirim:</strong> " . ($record->sent_at ? $record->sent_at->format('d M Y H:i:s') : '-') . "</div>
                                </div>
                                <div class='p-3 rounded-xl bg-gray-50 dark:bg-gray-800/60 border border-gray-200 dark:border-gray-700 text-xs whitespace-pre-line font-sans leading-relaxed'>
                                    {$pesanHtml}
                                </div>
                                {$errorHtml}
                                {$payloadHtml}
                            </div>
                        ");
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),

                Actions\Action::make('kirim_ulang')
                    ->label('Kirim Ulang')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->visible(fn (WhatsAppLog $record) => $record->status === 'failed')
                    ->requiresConfirmation()
                    ->modalHeading('Kirim Ulang Pesan WhatsApp')
                    ->modalDescription(fn (WhatsAppLog $record) => "Kirim ulang pesan ke nomor {$record->nomor_tujuan}?")
                    ->action(function (WhatsAppLog $record, WhatsAppService $waService) {
                        $sent = $waService->sendMessage(
                            $record->nomor_tujuan,
                            $record->pesan,
                            $record->tipe_pesan,
                            $record->referensi_id,
                            $record->nama_penerima
                        );

                        if ($sent) {
                            Notification::make()
                                ->title('Pesan Berhasil Dikirim Ulang')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Pengiriman Ulang Gagal')
                                ->danger()
                                ->send();
                        }
                    }),

                Actions\DeleteAction::make()
                    ->label('Hapus Log'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWhatsAppLogs::route('/'),
        ];
    }
}
