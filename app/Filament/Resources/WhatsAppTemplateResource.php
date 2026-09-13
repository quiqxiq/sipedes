<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhatsAppTemplateResource\Pages;
use App\Models\WhatsAppTemplate;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class WhatsAppTemplateResource extends Resource
{
    protected static ?string $model = WhatsAppTemplate::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-duplicate';

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan & Sistem';

    protected static ?string $navigationLabel = 'Template WhatsApp';

    protected static ?string $modelLabel = 'Template WhatsApp';

    protected static ?string $pluralModelLabel = 'Daftar Template WhatsApp';

    protected static ?int $navigationSort = 4;

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Identitas Template')
                    ->description('Konfigurasi kode dan tujuan template pesan.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('kode')
                                    ->label('Kode Unik Template')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->disabled(fn (?WhatsAppTemplate $record) => $record !== null)
                                    ->helperText('Contoh: surat_masuk_petugas, surat_disetujui_warga'),

                                Forms\Components\TextInput::make('nama')
                                    ->label('Nama / Judul Template')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('kategori')
                                    ->label('Kategori Pelayanan')
                                    ->options([
                                        'surat' => 'Layanan Surat',
                                        'pengaduan' => 'Layanan Pengaduan',
                                        'sistem' => 'Sistem & Keamanan',
                                    ])
                                    ->required(),

                                Forms\Components\Select::make('target')
                                    ->label('Penerima Notifikasi')
                                    ->options([
                                        'warga' => 'Warga Pemohon / Pelapor',
                                        'petugas' => 'Petugas / Pamong Desa',
                                    ])
                                    ->required(),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true)
                                    ->inline(false)
                                    ->helperText('Hanya template aktif yang akan dikirim secara otomatis.'),
                            ]),
                    ]),

                Section::make('Konten Pesan WhatsApp')
                    ->description('Tuliskan struktur pesan WhatsApp dengan variabel token dinamis.')
                    ->schema([
                        Forms\Components\Textarea::make('konten')
                            ->label('Isi Pesan WhatsApp')
                            ->rows(10)
                            ->required()
                            ->helperText('Gunakan format pesan WhatsApp: *tebal*, _miring_, ~coret~. Sisipkan token dalam kurung kurawal seperti {nama_pemohon}, {nomor_permohonan}, dll.'),

                        Forms\Components\Placeholder::make('panduan_token')
                            ->label('Daftar Variabel Token yang Tersedia:')
                            ->content(function (?WhatsAppTemplate $record) {
                                if (!$record || empty($record->variabel_tersedia)) {
                                    return new HtmlString('<p class="text-xs text-gray-500">Variabel umum: <code>{nama_desa}</code>, <code>{kontak_desa}</code></p>');
                                }

                                $badges = collect($record->variabel_tersedia)
                                    ->map(fn ($var) => "<span class='inline-block px-2 py-1 mr-1.5 mb-1.5 text-xs font-mono font-semibold rounded-md bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300'>{{$var}}</span>")
                                    ->implode('');

                                return new HtmlString("
                                    <div class='mt-1 text-xs text-gray-600 dark:text-gray-400'>
                                        <p class='mb-2'>Klik atau salin token di bawah ini ke dalam pesan di atas:</p>
                                        <div class='flex flex-wrap'>{$badges}</div>
                                    </div>
                                ");
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->label('Kode Template')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Template')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'surat' => 'success',
                        'pengaduan' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'surat' => '📄 Surat',
                        'pengaduan' => '📢 Pengaduan',
                        default => '⚙️ Sistem',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('target')
                    ->label('Target Penerima')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'warga' => 'primary',
                        'petugas' => 'purple',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'warga' => '👤 Warga',
                        'petugas' => '👨‍💼 Petugas',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('kategori', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Filter Kategori')
                    ->options([
                        'surat' => 'Layanan Surat',
                        'pengaduan' => 'Layanan Pengaduan',
                        'sistem' => 'Sistem',
                    ]),

                Tables\Filters\SelectFilter::make('target')
                    ->label('Filter Penerima')
                    ->options([
                        'warga' => 'Warga',
                        'petugas' => 'Petugas',
                    ]),
            ])
            ->actions([
                Actions\Action::make('preview')
                    ->label('Preview Pesan')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn (WhatsAppTemplate $record) => "Pratinjau Pesan: {$record->nama}")
                    ->modalContent(function (WhatsAppTemplate $record) {
                        $dummyData = [
                            'jenis_surat' => 'Surat Keterangan Usaha (SKU)',
                            'nomor_permohonan' => 'SRT/20260912/AB89X',
                            'nama_pemohon' => 'Ahmad Fawaid',
                            'dusun' => 'Dusun Karang Baru',
                            'tanggal_pengajuan' => date('d M Y H:i'),
                            'link_admin' => url('/admin/permohonan-surats'),
                            'link_status' => url('/layanan/riwayat/1'),
                            'link_download_pdf' => url('/layanan/surat/1/pdf'),
                            'nama_petugas' => 'Ach. Subairi (Kasi Pelayanan)',
                            'tanggal_selesai' => date('d M Y H:i'),
                            'catatan_petugas' => 'Lampiran foto tempat usaha sudah sesuai dan diverifikasi.',
                            'kode_tiket' => 'PGD-20260912-4521',
                            'nama_pelapor' => 'Siti Aminah',
                            'kategori' => 'Infrastruktur Jalan',
                            'judul_pengaduan' => 'Lampu Penerangan Jalan Rusak di Dekat Masjid Dusun Pesisir',
                            'tanggal_laporan' => date('d M Y H:i'),
                            'tanggapan_petugas' => 'Terima kasih atas laporannya. Tim sarana balai desa telah mengganti bohlam lampu pada hari ini.',
                        ];

                        $rendered = $record->render($dummyData);
                        $formattedHtml = nl2br(e($rendered));

                        return new HtmlString("
                            <div class='p-4 rounded-2xl bg-[#EFEAE2] dark:bg-[#111B21] border border-gray-300 dark:border-gray-800 max-w-lg mx-auto shadow-inner'>
                                <div class='text-[10px] text-center text-gray-500 mb-3'>SIMULASI TAMPILAN WHATSAPP</div>
                                <div class='p-4 rounded-xl bg-white dark:bg-[#202C33] text-gray-900 dark:text-gray-100 shadow-md text-xs leading-relaxed whitespace-pre-line font-sans border-l-4 border-emerald-500'>
                                    {$formattedHtml}
                                </div>
                                <div class='text-right text-[10px] text-gray-400 mt-1.5'>
                                    <span>" . date('H:i') . "</span> ✓✓
                                </div>
                            </div>
                        ");
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),

                Actions\EditAction::make()
                    ->label('Sunting'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWhatsAppTemplates::route('/'),
            'create' => Pages\CreateWhatsAppTemplate::route('/create'),
            'edit' => Pages\EditWhatsAppTemplate::route('/{record}/edit'),
        ];
    }
}
