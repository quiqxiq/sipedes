<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Pengaduan;
use App\Models\PerangkatDesa;
use App\Models\ProgramBantuan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PelayananDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $warga = User::where('role', 'warga')->first();

        // 1. Perangkat / Pamong Desa Rombiyah Barat
        $pamongList = [
            [
                'nama' => 'Farhah',
                'jabatan' => 'Kepala Desa',
                'wilayah_tugas' => 'Pemerintah Desa Rombiyah Barat',
                'nip_atau_nomor' => '197508122021122001',
                'foto' => 'images/pamong/kades_farhah.jpg',
                'telepon' => '082334567890',
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'nama' => 'Ahmad Fauzi, S.Pd',
                'jabatan' => 'Sekretaris Desa',
                'wilayah_tugas' => 'Kantor Balai Desa',
                'nip_atau_nomor' => '198205102015031002',
                'foto' => 'images/pamong/sekdes_fauzi.jpg',
                'telepon' => '081234567801',
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'nama' => 'Moh. Syafi\'i',
                'jabatan' => 'Kaur Keuangan & Bendahara Desa',
                'wilayah_tugas' => 'Kantor Balai Desa',
                'nip_atau_nomor' => '198803152019011003',
                'foto' => 'images/pamong/kaur_syafii.jpg',
                'telepon' => '081234567802',
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'nama' => 'Siti Aminah',
                'jabatan' => 'Kaur Tata Usaha & Umum',
                'wilayah_tugas' => 'Kantor Balai Desa',
                'nip_atau_nomor' => '199007202020012004',
                'foto' => 'images/pamong/kaur_aminah.jpg',
                'telepon' => '081234567803',
                'urutan' => 4,
                'is_active' => true,
            ],
            [
                'nama' => 'Ali Wafa',
                'jabatan' => 'Kasi Pelayanan & Kesejahteraan',
                'wilayah_tugas' => 'Kantor Balai Desa',
                'nip_atau_nomor' => '198511222018021005',
                'foto' => 'images/pamong/kasi_aliwafa.jpg',
                'telepon' => '081234567804',
                'urutan' => 5,
                'is_active' => true,
            ],
            [
                'nama' => 'Suhrawi',
                'jabatan' => 'Kepala Dusun Kebunan',
                'wilayah_tugas' => 'Dusun Kebunan',
                'nip_atau_nomor' => '3529102904650001',
                'foto' => 'images/pamong/kasun_suhrawi.jpg',
                'telepon' => '081234567805',
                'urutan' => 6,
                'is_active' => true,
            ],
            [
                'nama' => 'Hariya',
                'jabatan' => 'Kepala Dusun Buwa',
                'wilayah_tugas' => 'Dusun Buwa',
                'nip_atau_nomor' => '3529100107680167',
                'foto' => 'images/pamong/kasun_hariya.jpg',
                'telepon' => '081234567806',
                'urutan' => 7,
                'is_active' => true,
            ],
            [
                'nama' => 'Abd. Muni',
                'jabatan' => 'Kepala Dusun Tanodung',
                'wilayah_tugas' => 'Dusun Tanodung',
                'nip_atau_nomor' => '3529102104600002',
                'foto' => 'images/pamong/kasun_muni.jpg',
                'telepon' => '081234567807',
                'urutan' => 8,
                'is_active' => true,
            ],
            [
                'nama' => 'Moh. Sabri',
                'jabatan' => 'Kepala Dusun Rombiya',
                'wilayah_tugas' => 'Dusun Rombiya',
                'nip_atau_nomor' => '3529100107430086',
                'foto' => 'images/pamong/kasun_sabri.jpg',
                'telepon' => '081234567808',
                'urutan' => 9,
                'is_active' => true,
            ],
            [
                'nama' => 'Moh. Rofiqi',
                'jabatan' => 'Kepala Dusun Kalampok',
                'wilayah_tugas' => 'Dusun Kalampok',
                'nip_atau_nomor' => '3529101504040003',
                'foto' => 'images/pamong/kasun_rofiqi.jpg',
                'telepon' => '081234567809',
                'urutan' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($pamongList as $pamong) {
            PerangkatDesa::updateOrCreate(
                ['jabatan' => $pamong['jabatan']],
                $pamong
            );
        }

        // 2. Program Bantuan Sosial Desa
        $bantuanList = [
            [
                'nama_program' => 'BLT Dana Desa (BLT-DD) Rombiyah Barat TA 2026',
                'kategori' => 'bansos_tunai',
                'sumber_dana' => 'Dana Desa (APBDes) TA 2026',
                'kriteria_penerima' => 'Keluarga Penerima Manfaat (KPM) kategori miskin ekstrem, kehilangan mata pencaharian, lansia tunggal, atau anggota keluarga sakit menahun di 5 Dusun.',
                'syarat_dokumen' => ['KTP Pemohon', 'Kartu Keluarga (KK)', 'Surat Keterangan Tidak Mampu (SKTM)', 'Foto Rumah Tinggal'],
                'besaran_bantuan' => 'Rp 300.000 / bulan',
                'kuota_penerima' => 85,
                'tahun_anggaran' => 2026,
                'status' => 'penyaluran',
                'keterangan' => 'Penyaluran dilakukan setiap triwulan di Balai Desa Rombiyah Barat dengan membawa KTP dan KK asli.',
            ],
            [
                'nama_program' => 'Bantuan Pangan Cadangan Beras Pemerintah (CBP)',
                'kategori' => 'pangan_sembako',
                'sumber_dana' => 'Badan Pangan Nasional / Bulog',
                'kriteria_penerima' => 'Warga terdata dalam P3KE (Pensasaran Percepatan Penghapusan Kemiskinan Ekstrem) Desa Rombiyah Barat.',
                'syarat_dokumen' => ['Fotokopi KTP', 'Fotokopi KK', 'Undangan barcode dari Kantor Pos/Desa'],
                'besaran_bantuan' => '10 kg Beras Medium / Bulan',
                'kuota_penerima' => 320,
                'tahun_anggaran' => 2026,
                'status' => 'penyaluran',
                'keterangan' => 'Pengambilan beras dikoordinasikan oleh masing-masing Kepala Dusun di Balai Desa.',
            ],
            [
                'nama_program' => 'Bantuan Sarana Pupuk Organik & Pompa Air Pertanian',
                'kategori' => 'pertanian_bibit',
                'sumber_dana' => 'Ketahanan Pangan Dana Desa 20% & Disperta Sumenep',
                'kriteria_penerima' => 'Kelompok Tani (Poktan) & petani aktif tembakau/jagung di Dusun Kebunan, Buwa, Tanodung, Rombiya, Kalampok.',
                'syarat_dokumen' => ['KTP Petani', 'Bukti Penggarap / Sertifikat / SPPT Lahan', 'Rekomendasi Ketua Poktan'],
                'besaran_bantuan' => 'Subsidi Pupuk Organik Cair & Pinjam Pakai Pompa Air Sawah',
                'kuota_penerima' => 150,
                'tahun_anggaran' => 2026,
                'status' => 'dibuka',
                'keterangan' => 'Mendukung produktivitas komoditas tembakau Madura dan tanaman pangan musim tanam 2026.',
            ],
            [
                'nama_program' => 'Program PMT Gizi Balita & Bumil (Pencegahan Stunting Desa)',
                'kategori' => 'kesehatan_stunting',
                'sumber_dana' => 'Bidang Kesehatan Dana Desa & Puskesmas Ganding',
                'kriteria_penerima' => 'Ibu hamil KEK (Kurang Energi Kronis) dan balita gizi kurang di 5 Posyandu Dusun.',
                'syarat_dokumen' => ['Buku KIA / KMS Balita', 'Fotokopi KTP Orang Tua', 'KK'],
                'besaran_bantuan' => 'Paket Makanan Tambahan Bernutrisi Tinggi (Telur, Susu, Biskuit Gizi) selama 90 hari',
                'kuota_penerima' => 45,
                'tahun_anggaran' => 2026,
                'status' => 'penyaluran',
                'keterangan' => 'Disalurkan saat jadwal posyandu bulanan di masing-masing dusun.',
            ],
        ];

        foreach ($bantuanList as $bantuan) {
            ProgramBantuan::updateOrCreate(
                ['nama_program' => $bantuan['nama_program']],
                $bantuan
            );
        }

        // 3. Berita & Agenda Desa
        $beritaList = [
            [
                'judul' => 'Musrenbangdes Rombiyah Barat: Prioritaskan Rabat Beton Jalan Antar-Dusun dan Pompa Air Pertanian',
                'slug' => 'musrenbangdes-prioritas-jalan-dan-pertanian-2026',
                'kategori' => 'berita',
                'ringkasan' => 'Pemerintah Desa Rombiyah Barat bersama BPD dan tokoh masyarakat 5 dusun menyepakati fokus pembangunan jalan rabat beton dan penguatan irigasi pertanian.',
                'konten' => "Pemerintah Desa Rombiyah Barat, Kecamatan Ganding, Kabupaten Sumenep menggelar Musyawarah Perencanaan Pembangunan Desa (Musrenbangdes) di Balai Desa Rombiyah Barat.\n\nKepala Desa Rombiyah Barat, Farhah, menegaskan bahwa usulan prioritas dari Dusun Kebunan, Buwa, Tanodung, Rombiya, dan Kalampok berpusat pada perbaikan akses jalan tani rabat beton serta pengadaan sarana irigasi pompa air sawah guna mendukung musim tanam tembakau dan tanaman pangan.\n\n\"Kami berkomitmen agar alokasi Dana Desa benar-benar menjawab kebutuhan riil masyarakat petani dan meningkatkan konektivitas antar dusun,\" ungkap Kepala Desa.",
                'gambar_cover' => null,
                'penulis_id' => $admin?->id,
                'is_published' => true,
                'views' => 142,
                'published_at' => now()->subDays(3),
            ],
            [
                'judul' => 'Jadwal Posyandu Terpadu Balita dan Lansia di 5 Dusun Desa Rombiyah Barat Bulan Ini',
                'slug' => 'jadwal-posyandu-terpadu-5-dusun-bulan-ini',
                'kategori' => 'posyandu',
                'ringkasan' => 'Simak jadwal dan lokasi penimbangan balita, imunisasi rutin, serta pemeriksaan kesehatan lansia di 5 Dusun.',
                'konten' => "Puskesmas Pembantu bersama Kader Posyandu Desa Rombiyah Barat mengumumkan jadwal pelayanan Posyandu Terpadu untuk bulan ini sebagai berikut:\n\n1. Posyandu Dusun Kebunan: Setiap tanggal 5 (Rumah Kasun Kebunan)\n2. Posyandu Dusun Buwa: Setiap tanggal 8 (Poskesdes Buwa)\n3. Posyandu Dusun Tanodung: Setiap tanggal 12 (Balai RT 03 Tanodung)\n4. Posyandu Dusun Rombiya: Setiap tanggal 16 (Halaman RA Sumber Mas)\n5. Posyandu Dusun Kalampok: Setiap tanggal 20 (Rumah Kasun Kalampok)\n\nLayanan meliputi penimbangan berat badan, pengukuran tinggi badan balita, imunisasi lengkap, serta pembagian PMT (Pemberian Makanan Tambahan).",
                'gambar_cover' => null,
                'penulis_id' => $admin?->id,
                'is_published' => true,
                'views' => 98,
                'published_at' => now()->subDays(6),
            ],
            [
                'judul' => 'BUMDes Kencana Rombiyah Barat Buka Layanan Distribusi Saprotan dan Agen Pembayaran Resmi',
                'slug' => 'bumdes-kencana-buka-layanan-saprotan-dan-pembayaran',
                'kategori' => 'bumdes',
                'ringkasan' => 'BUMDes Kencana memperluas unit usaha untuk mempermudah petani mendapatkan sarana produksi tani dan pembayaran listrik/air.',
                'konten' => "Badan Usaha Milik Desa (BUMDes) Kencana Desa Rombiyah Barat, Kecamatan Ganding kini resmi mengoperasikan unit penyedia Saprotan (Sarana Produksi Pertanian) dan agen pembayaran digital.\n\nUnit ini bertujuan mempermudah petani di 5 dusun dalam memperoleh pupuk, benih unggul jagung dan tembakau, serta melayani pembayaran tagihan listrik, BPJS, dan transfer perbankan tanpa harus menempuh jarak jauh ke pusat kecamatan.",
                'gambar_cover' => null,
                'penulis_id' => $admin?->id,
                'is_published' => true,
                'views' => 175,
                'published_at' => now()->subDays(10),
            ],
        ];

        foreach ($beritaList as $berita) {
            Berita::updateOrCreate(
                ['slug' => $berita['slug']],
                $berita
            );
        }

        // 4. Contoh Pengaduan Warga Sampel
        if ($warga) {
            Pengaduan::updateOrCreate(
                ['kode_tiket' => 'LAPOR-2026-0001'],
                [
                    'user_id' => $warga->id,
                    'kategori' => 'jalan_infrastruktur',
                    'dusun' => 'Dusun Kebunan',
                    'judul' => 'Penerangan Jalan dan Rabat Beton Rusak Dekat Batas Sawah RT 02',
                    'deskripsi' => 'Mohon bantuan perbaikan rabat beton jalan tani yang ambles sekitar 15 meter setelah hujan lebat, serta penambahan 1 titik lampu jalan di persimpangan jalan Dusun Kebunan menuju Dusun Buwa.',
                    'lokasi_detail' => 'Jalan Tani Dusun Kebunan RT 002 RW 002',
                    'status' => 'diproses',
                    'tanggapan_petugas' => 'Laporan telah diverifikasi oleh Kasi Kesejahteraan dan Kasun Kebunan. Perbaikan masuk dalam alokasi pemeliharaan jalan lingkungan bulan ini.',
                    'petugas_id' => $admin?->id,
                    'ditanggapi_at' => now()->subDays(1),
                ]
            );

            Pengaduan::updateOrCreate(
                ['kode_tiket' => 'LAPOR-2026-0002'],
                [
                    'user_id' => $warga->id,
                    'kategori' => 'pertanian_irigasi',
                    'dusun' => 'Dusun Tanodung',
                    'judul' => 'Permohonan Bantuan Pompa Air Sawah Musim Tanam',
                    'deskripsi' => 'Kelompok tani di Dusun Tanodung RT 03 membutuhkan tambahan giliran operasional pompa air sawah desa karena sumur bor dangkal mulai surut.',
                    'lokasi_detail' => 'Lahan Persawahan Dusun Tanodung RT 003 RW 004',
                    'status' => 'selesai',
                    'tanggapan_petugas' => 'Pompa air cadangan BUMDes Kencana telah disalurkan dan dioperasikan bersama pengurus Poktan Tanodung.',
                    'petugas_id' => $admin?->id,
                    'ditanggapi_at' => now()->subHours(5),
                ]
            );
        }
    }
}
