<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suratList = [
            [
                'kode' => 'SKTM',
                'nama' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'deskripsi' => 'Surat keterangan untuk keperluan beasiswa, keringanan biaya berobat, atau bantuan sosial.',
                'estimasi_waktu' => '1-2 Hari Kerja',
                'syarat' => [
                    'Fotokopi KTP Pemohon',
                    'Fotokopi Kartu Keluarga (KK)',
                    'Surat Pengantar RT/RW',
                    'Foto Rumah/Kondisi Ekonomi (jika diperlukan)',
                ],
                'is_active' => true,
            ],
            [
                'kode' => 'SKD',
                'nama' => 'Surat Keterangan Domisili',
                'deskripsi' => 'Surat keterangan menetap/bertempat tinggal di wilayah Desa Rombiyah Barat.',
                'estimasi_waktu' => '1 Hari Kerja',
                'syarat' => [
                    'Fotokopi KTP',
                    'Fotokopi Kartu Keluarga (KK)',
                    'Surat Pengantar RT/RW',
                ],
                'is_active' => true,
            ],
            [
                'kode' => 'SKU',
                'nama' => 'Surat Keterangan Usaha (SKU)',
                'deskripsi' => 'Surat keterangan legalitas usaha berskala mikro/kecil di wilayah desa.',
                'estimasi_waktu' => '1-2 Hari Kerja',
                'syarat' => [
                    'Fotokopi KTP Pemilik Usaha',
                    'Fotokopi Kartu Keluarga (KK)',
                    'Surat Pengantar RT/RW',
                    'Foto Tempat Usaha',
                ],
                'is_active' => true,
            ],
            [
                'kode' => 'SKN',
                'nama' => 'Surat Pengantar Nikah (N1-N4)',
                'deskripsi' => 'Surat pengantar untuk pendaftaran pernikahan ke KUA / Catatan Sipil.',
                'estimasi_waktu' => '2-3 Hari Kerja',
                'syarat' => [
                    'Fotokopi KTP Calon Mempelai & Orang Tua',
                    'Fotokopi Kartu Keluarga (KK)',
                    'Fotokopi Akta Kelahiran & Ijazah Terakhir',
                    'Pas Foto 3x4 Background Biru/Merah (4 lembar)',
                    'Surat Pengantar RT/RW',
                ],
                'is_active' => true,
            ],
            [
                'kode' => 'SKK',
                'nama' => 'Surat Keterangan Kematian',
                'deskripsi' => 'Surat keterangan resmi mengenai kematian warga desa.',
                'estimasi_waktu' => '1 Hari Kerja',
                'syarat' => [
                    'Fotokopi KTP Almarhum/Almarhumah',
                    'Fotokopi Kartu Keluarga (KK)',
                    'Surat Keterangan Kematian dari Dokter/RS (jika ada)',
                    'Fotokopi KTP Pelapor/Ahli Waris',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($suratList as $surat) {
            JenisSurat::updateOrCreate(
                ['kode' => $surat['kode']],
                $surat
            );
        }
    }
}
