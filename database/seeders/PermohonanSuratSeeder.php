<?php

namespace Database\Seeders;

use App\Models\PermohonanSurat;
use Illuminate\Database\Seeder;

class PermohonanSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Data contoh permohonan surat untuk warga SUHRAWI (NIK 3529102904650001)
     * agar halaman riwayat warga dan panel admin dapat ditampilkan/di-screenshot.
     */
    public function run(): void
    {
        $warga = \App\Models\User::where('nik', '3529102904650001')->first();
        $petugas = \App\Models\User::where('role', 'admin')->first();

        if (! $warga) {
            return;
        }

        $permohonanList = [
            [
                'nomor_permohonan' => 'SRT/20260813/00001',
                'status' => 'disetujui',
                'jenis_surat_kode' => 'SKTM',
                'catatan_petugas' => 'Berkas lengkap. Surat Keterangan Tidak Mampu telah diterbitkan.',
                'tanggal_diproses' => now()->subDays(2),
                'tanggal_selesai' => now()->subDay(),
            ],
            [
                'nomor_permohonan' => 'SRT/20260813/00002',
                'status' => 'diproses',
                'jenis_surat_kode' => 'SKD',
                'catatan_petugas' => null,
                'tanggal_diproses' => now()->subDay(),
                'tanggal_selesai' => null,
            ],
            [
                'nomor_permohonan' => 'SRT/20260813/00003',
                'status' => 'butuh_koreksi',
                'jenis_surat_kode' => 'SKU',
                'catatan_petugas' => 'Mohon lampirkan foto tempat usaha yang lebih jelas.',
                'tanggal_diproses' => now()->subHours(5),
                'tanggal_selesai' => null,
            ],
            [
                'nomor_permohonan' => 'SRT/20260813/00004',
                'status' => 'diajukan',
                'jenis_surat_kode' => 'SKN',
                'catatan_petugas' => null,
                'tanggal_diproses' => null,
                'tanggal_selesai' => null,
            ],
        ];

        foreach ($permohonanList as $data) {
            $jenisSurat = \App\Models\JenisSurat::where('kode', $data['jenis_surat_kode'])->first();

            PermohonanSurat::updateOrCreate(
                ['nomor_permohonan' => $data['nomor_permohonan']],
                [
                    'user_id' => $warga->id,
                    'petugas_id' => $petugas?->id,
                    'jenis_surat_id' => $jenisSurat?->id,
                    'status' => $data['status'],
                    'catatan_petugas' => $data['catatan_petugas'],
                    'data_pemohon' => [
                        'nama' => $warga->name,
                        'nik' => $warga->nik,
                        'alamat' => $warga->alamat,
                    ],
                    'tanggal_diproses' => $data['tanggal_diproses'],
                    'tanggal_selesai' => $data['tanggal_selesai'],
                ]
            );
        }
    }
}
