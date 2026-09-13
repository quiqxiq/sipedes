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
                    [
                        'nama' => 'Fotokopi KTP Pemohon',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan e-KTP asli pemohon yang masih berlaku.',
                    ],
                    [
                        'nama' => 'Fotokopi Kartu Keluarga (KK)',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan Kartu Keluarga warga Desa Rombiya Barat.',
                    ],
                    [
                        'nama' => 'Surat Pengantar RT/RW',
                        'wajib' => true,
                        'keterangan' => 'Surat pengantar asli bertanda tangan Ketua RT/RW setempat.',
                    ],
                    [
                        'nama' => 'Foto Rumah / Kondisi Ekonomi',
                        'wajib' => false,
                        'keterangan' => 'Foto tampak depan rumah atau bukti pendukung kondisi ekonomi (opsional).',
                    ],
                ],
                'is_active' => true,
            ],
            [
                'kode' => 'SKD',
                'nama' => 'Surat Keterangan Domisili',
                'deskripsi' => 'Surat keterangan menetap/bertempat tinggal di wilayah Desa Rombiya Barat.',
                'estimasi_waktu' => '1 Hari Kerja',
                'syarat' => [
                    [
                        'nama' => 'Fotokopi KTP',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan KTP pemohon.',
                    ],
                    [
                        'nama' => 'Fotokopi Kartu Keluarga (KK)',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan Kartu Keluarga.',
                    ],
                    [
                        'nama' => 'Surat Pengantar RT/RW',
                        'wajib' => true,
                        'keterangan' => 'Surat pengantar domisili dari Ketua RT/RW tempat tinggal saat ini.',
                    ],
                ],
                'is_active' => true,
            ],
            [
                'kode' => 'SKU',
                'nama' => 'Surat Keterangan Usaha (SKU)',
                'deskripsi' => 'Surat keterangan legalitas usaha berskala mikro/kecil di wilayah desa.',
                'estimasi_waktu' => '1-2 Hari Kerja',
                'syarat' => [
                    [
                        'nama' => 'Fotokopi KTP Pemilik Usaha',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan KTP pemilik usaha warga Rombiya Barat.',
                    ],
                    [
                        'nama' => 'Fotokopi Kartu Keluarga (KK)',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan Kartu Keluarga pemilik usaha.',
                    ],
                    [
                        'nama' => 'Surat Pengantar RT/RW',
                        'wajib' => true,
                        'keterangan' => 'Surat pengantar keterangan usaha dari RT/RW lokasi usaha.',
                    ],
                    [
                        'nama' => 'Foto Tempat / Aktivitas Usaha',
                        'wajib' => true,
                        'keterangan' => 'Foto tampak depan tempat usaha atau barang dagangan/kegiatan produksi.',
                    ],
                ],
                'is_active' => true,
            ],
            [
                'kode' => 'SKN',
                'nama' => 'Surat Pengantar Nikah (N1-N4)',
                'deskripsi' => 'Surat pengantar untuk pendaftaran pernikahan ke KUA / Catatan Sipil.',
                'estimasi_waktu' => '2-3 Hari Kerja',
                'syarat' => [
                    [
                        'nama' => 'Fotokopi KTP Calon Mempelai & Orang Tua',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan KTP calon pengantin dan kedua orang tua.',
                    ],
                    [
                        'nama' => 'Fotokopi Kartu Keluarga (KK)',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan Kartu Keluarga calon mempelai.',
                    ],
                    [
                        'nama' => 'Fotokopi Akta Kelahiran & Ijazah Terakhir',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan Akta Lahir dan Ijazah untuk verifikasi kesesuaian nama & tgl lahir.',
                    ],
                    [
                        'nama' => 'Pas Foto 3x4 Calon Pengantin',
                        'wajib' => true,
                        'keterangan' => 'Pas foto terbaru ukuran 3x4 background biru/merah.',
                    ],
                    [
                        'nama' => 'Surat Pengantar RT/RW',
                        'wajib' => true,
                        'keterangan' => 'Surat pengantar nikah dari Ketua RT/RW domisili.',
                    ],
                ],
                'is_active' => true,
            ],
            [
                'kode' => 'SKK',
                'nama' => 'Surat Keterangan Kematian',
                'deskripsi' => 'Surat keterangan resmi mengenai kematian warga desa.',
                'estimasi_waktu' => '1 Hari Kerja',
                'syarat' => [
                    [
                        'nama' => 'Fotokopi KTP Almarhum/Almarhumah',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan KTP almarhum/almarhumah yang meninggal dunia.',
                    ],
                    [
                        'nama' => 'Fotokopi Kartu Keluarga (KK)',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan KK almarhum/almarhumah.',
                    ],
                    [
                        'nama' => 'Surat Keterangan Kematian Dokter/RS/Bidan',
                        'wajib' => false,
                        'keterangan' => 'Surat kematian medis dari Puskesmas/RS/Bidan jika meninggal di fasilitas kesehatan.',
                    ],
                    [
                        'nama' => 'Fotokopi KTP Pelapor / Ahli Waris',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan KTP pelapor atau perwakilan keluarga.',
                    ],
                ],
                'is_active' => true,
            ],
            [
                'kode' => 'SKT',
                'nama' => 'Surat Keterangan Kepemilikan Ternak (Sapi/Kambing)',
                'deskripsi' => 'Surat keterangan kepemilikan atau pengantar jual beli hewan ternak sapi Madura/kambing warga desa.',
                'estimasi_waktu' => '1 Hari Kerja',
                'syarat' => [
                    [
                        'nama' => 'Fotokopi KTP Pemilik Ternak',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan KTP pemilik hewan ternak.',
                    ],
                    [
                        'nama' => 'Fotokopi Kartu Keluarga (KK)',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan Kartu Keluarga pemilik ternak.',
                    ],
                    [
                        'nama' => 'Surat Pengantar RT/RW',
                        'wajib' => true,
                        'keterangan' => 'Surat pengantar jual beli / kepemilikan ternak dari RT/RW.',
                    ],
                    [
                        'nama' => 'Foto Hewan Ternak',
                        'wajib' => true,
                        'keterangan' => 'Foto fisik hewan ternak (sapi/kambing) menampilkan ciri fisik warna dan tanduk.',
                    ],
                ],
                'is_active' => true,
            ],
            [
                'kode' => 'SKBM',
                'nama' => 'Surat Keterangan Belum Menikah',
                'deskripsi' => 'Surat keterangan status lajang / belum pernah menikah untuk persyaratan kerja, beasiswa, atau kedinasan.',
                'estimasi_waktu' => '1 Hari Kerja',
                'syarat' => [
                    [
                        'nama' => 'Fotokopi KTP Pemohon',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan KTP pemohon yang bersangkutan.',
                    ],
                    [
                        'nama' => 'Fotokopi Kartu Keluarga (KK)',
                        'wajib' => true,
                        'keterangan' => 'Foto atau scan Kartu Keluarga pemohon.',
                    ],
                    [
                        'nama' => 'Surat Pernyataan Belum Menikah Bermaterai',
                        'wajib' => true,
                        'keterangan' => 'Surat pernyataan belum menikah bermaterai Rp 10.000 yang ditandatangani pemohon.',
                    ],
                    [
                        'nama' => 'Surat Pengantar RT/RW',
                        'wajib' => true,
                        'keterangan' => 'Surat pengantar status belum menikah dari Ketua RT/RW setempat.',
                    ],
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
