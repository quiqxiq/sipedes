<?php

namespace App\Filament\Widgets;

use App\Models\KnowledgeDocument;
use App\Models\PermohonanSurat;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $wargaCount = User::where('role', 'warga')->count();

        return [
            Stat::make('Warga Terdaftar SIPEDES', $wargaCount)
                ->description('Sinkron live dengan landing page')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Total Penduduk Desa', '1.403 Jiwa')
                ->description('652 Laki-laki &bull; 751 Perempuan (560 KK)')
                ->descriptionIcon('heroicon-m-identification')
                ->color('success'),

            Stat::make('Total Permohonan Surat', PermohonanSurat::count())
                ->description('Seluruh permohonan masuk')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),

            Stat::make('Menunggu Verifikasi', PermohonanSurat::where('status', 'diajukan')->count())
                ->description('Status: Diajukan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Surat Disetujui', PermohonanSurat::where('status', 'disetujui')->count())
                ->description('Selesai diterbitkan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Dokumen Pengetahuan (RAG)', KnowledgeDocument::count())
                ->description('Terindeks di Dify AI')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('secondary'),
        ];
    }
}
