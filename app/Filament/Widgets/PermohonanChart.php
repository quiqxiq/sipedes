<?php

namespace App\Filament\Widgets;

use App\Models\PermohonanSurat;
use Filament\Widgets\ChartWidget;

class PermohonanChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Status Permohonan Surat';

    protected function getData(): array
    {
        $diajukan = PermohonanSurat::where('status', 'diajukan')->count();
        $diproses = PermohonanSurat::where('status', 'diproses')->count();
        $disetujui = PermohonanSurat::where('status', 'disetujui')->count();
        $ditolak = PermohonanSurat::where('status', 'ditolak')->count();
        $butuhKoreksi = PermohonanSurat::where('status', 'butuh_koreksi')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Permohonan',
                    'data' => [$diajukan, $diproses, $disetujui, $butuhKoreksi, $ditolak],
                    'backgroundColor' => [
                        '#f59e0b', // diajukan (amber)
                        '#0ea5e9', // diproses (sky)
                        '#10b981', // disetujui (emerald)
                        '#f97316', // butuh_koreksi (orange)
                        '#ef4444', // ditolak (red)
                    ],
                ],
            ],
            'labels' => ['Diajukan', 'Diproses', 'Disetujui', 'Butuh Koreksi', 'Ditolak'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
