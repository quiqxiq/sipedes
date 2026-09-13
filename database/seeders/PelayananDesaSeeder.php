<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\PenerimaBantuan;
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

        // 1. Perangkat / Pamong Desa Rombiya Barat
        $pamongList = [
            [
                'nama' => 'Farhah',
                'jabatan' => 'Kepala Desa',
                'wilayah_tugas' => 'Desa Rombiya Barat',
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
                'nama' => 'Holis, S.Sos',
                'jabatan' => 'Kasi Pemerintahan',
                'wilayah_tugas' => 'Kantor Balai Desa',
                'nip_atau_nomor' => '198511252017041005',
                'foto' => 'images/pamong/kasi_holis.jpg',
                'telepon' => '081234567804',
                'urutan' => 5,
                'is_active' => true,
            ],
            [
                'nama' => 'Zainal Abidin',
                'jabatan' => 'Kasi Kesejahteraan (Kesra)',
                'wilayah_tugas' => 'Kantor Balai Desa',
                'nip_atau_nomor' => '198704182018021006',
                'foto' => 'images/pamong/kasi_zainal.jpg',
                'telepon' => '081234567805',
                'urutan' => 6,
                'is_active' => true,
            ],
            [
                'nama' => 'Mahrus',
                'jabatan' => 'Kasi Pelayanan',
                'wilayah_tugas' => 'Kantor Balai Desa',
                'nip_atau_nomor' => '199209142021051007',
                'foto' => 'images/pamong/kasi_mahrus.jpg',
                'telepon' => '081234567806',
                'urutan' => 7,
                'is_active' => true,
            ],
            [
                'nama' => 'H. Moh. Ridwan',
                'jabatan' => 'Kepala Dusun Kebunan (Kasun)',
                'wilayah_tugas' => 'Dusun Kebunan',
                'nip_atau_nomor' => '197806112016081008',
                'foto' => 'images/pamong/kasun_kebunan.jpg',
                'telepon' => '085234567811',
                'urutan' => 8,
                'is_active' => true,
            ],
            [
                'nama' => 'Abd. Razak',
                'jabatan' => 'Kepala Dusun Buwa (Kasun)',
                'wilayah_tugas' => 'Dusun Buwa',
                'nip_atau_nomor' => '198009222018071009',
                'foto' => 'images/pamong/kasun_buwa.jpg',
                'telepon' => '085234567812',
                'urutan' => 9,
                'is_active' => true,
            ],
            [
                'nama' => 'Samsul Arifin',
                'jabatan' => 'Kepala Dusun Tanodung (Kasun)',
                'wilayah_tugas' => 'Dusun Tanodung',
                'nip_atau_nomor' => '198402152019051010',
                'foto' => 'images/pamong/kasun_tanodung.jpg',
                'telepon' => '085234567813',
                'urutan' => 10,
                'is_active' => true,
            ],
            [
                'nama' => 'Ach. Subairi',
                'jabatan' => 'Kepala Dusun Rombiya (Kasun)',
                'wilayah_tugas' => 'Dusun Rombiya',
                'nip_atau_nomor' => '198608302020031011',
                'foto' => 'images/pamong/kasun_rombiya.jpg',
                'telepon' => '085234567814',
                'urutan' => 11,
                'is_active' => true,
            ],
            [
                'nama' => 'Moh. Kholil',
                'jabatan' => 'Kepala Dusun Kalampok (Kasun)',
                'wilayah_tugas' => 'Dusun Kalampok',
                'nip_atau_nomor' => '198304122017091012',
                'foto' => 'images/pamong/kasun_kalampok.jpg',
                'telepon' => '085234567815',
                'urutan' => 12,
                'is_active' => true,
            ],
        ];

        foreach ($pamongList as $pamong) {
            PerangkatDesa::updateOrCreate(
                ['nama' => $pamong['nama'], 'jabatan' => $pamong['jabatan']],
                $pamong
            );
        }

        // 2. Program Bantuan Sosial Desa (Kategori Lengkap)
        $bantuanList = [
            [
                'nama_program' => 'Program Keluarga Harapan (PKH) Kemensos RI',
                'kategori' => 'pkh',
                'sumber_dana' => 'Kementerian Sosial RI (APBN)',
                'kriteria_penerima' => 'Keluarga Miskin/Rentan terdaftar DTKS dengan komponen: Ibu Hamil/Nifas, Anak Balita, Anak Sekolah (SD/SMP/SMA), Lansia 60+ th, atau Penyandang Disabilitas Berat.',
                'syarat_dokumen' => ['KTP-el Asli', 'Kartu Keluarga (KK)', 'Kartu Keluarga Sejahtera (KKS/ATM Himbara)'],
                'besaran_bantuan' => 'Bantuan Tunai Bersyarat Rp 225.000 - Rp 750.000 / Tahap',
                'kuota_penerima' => 210,
                'tahun_anggaran' => 2026,
                'status' => 'penyaluran',
                'keterangan' => 'Pencairan melalui rekening Bank Himbara / PT Pos Indonesia terkoordinasi dengan Pendamping PKH Kecamatan Ganding.',
                'penanggung_jawab' => 'Zainal Abidin (Kasi Kesra) & Pendamping PKH',
            ],
            [
                'nama_program' => 'Bansos Lansia & Disabilitas (PKH Plus Jawa Timur)',
                'kategori' => 'bansos_lansia',
                'sumber_dana' => 'Dinas Sosial Provinsi Jawa Timur & Kab. Sumenep',
                'kriteria_penerima' => 'Lansia berusia 60 tahun ke atas kurang mampu dan penyandang disabilitas berat non-produktif di 5 Dusun.',
                'syarat_dokumen' => ['Fotokopi KTP Lansia', 'Fotokopi KK', 'Surat Keterangan Domisili Dusun'],
                'besaran_bantuan' => 'Bantuan Tunai Rp 600.000 / Triwulan',
                'kuota_penerima' => 60,
                'tahun_anggaran' => 2026,
                'status' => 'penyaluran',
                'keterangan' => 'Penyaluran dapat diwakilkan oleh ahli waris dalam satu KK dengan membawa surat kuasa dan KTP asli.',
                'penanggung_jawab' => 'Kasi Kesra & Kepala Dusun Setempat',
            ],
            [
                'nama_program' => 'Bantuan Cadangan Beras Pemerintah (CBP 10 Kg)',
                'kategori' => 'beras_cbp',
                'sumber_dana' => 'Badan Pangan Nasional (Bapanas) & Perum BULOG',
                'kriteria_penerima' => 'Warga KPM terdata dalam data Pensasaran Percepatan Penghapusan Kemiskinan Ekstrem (P3KE) Desa Rombiya Barat.',
                'syarat_dokumen' => ['KTP Asli Penerima', 'Kartu Keluarga (KK)', 'Undangan Pengambilan dari Balai Desa'],
                'besaran_bantuan' => '10 kg Beras Kualitas Medium / Bulan',
                'kuota_penerima' => 320,
                'tahun_anggaran' => 2026,
                'status' => 'penyaluran',
                'keterangan' => 'Pengambilan beras dipusatkan di Kantor Balai Desa Rombiya Barat per jadwal dusun.',
                'penanggung_jawab' => 'Pemerintah Desa & 5 Kepala Dusun',
            ],
            [
                'nama_program' => 'BLT Dana Desa (BLT-DD) Rombiya Barat TA 2026',
                'kategori' => 'blt_dana_desa',
                'sumber_dana' => 'Alokasi Dana Desa (APBDes Rombiya Barat 2026)',
                'kriteria_penerima' => 'Keluarga Penerima Manfaat (KPM) hasil Musyawarah Desa Khusus (Musdesus) yang belum tercover bansos PKH/BPNT.',
                'syarat_dokumen' => ['KTP Pemohon', 'Kartu Keluarga (KK)', 'Surat Penetapan KPM Musdesus'],
                'besaran_bantuan' => 'Rp 300.000 / Bulan (Disalurkan Per Triwulan Rp 900.000)',
                'kuota_penerima' => 85,
                'tahun_anggaran' => 2026,
                'status' => 'penyaluran',
                'keterangan' => 'Penyaluran tunai langsung di Balai Desa dihadiri BPD dan Pendamping Desa.',
                'penanggung_jawab' => 'Kepala Desa & Bendahara Desa',
            ],
            [
                'nama_program' => 'Bantuan Pangan Non Tunai (BPNT / Program Sembako)',
                'kategori' => 'bpnt_sembako',
                'sumber_dana' => 'Kementerian Sosial RI (APBN)',
                'kriteria_penerima' => 'Keluarga dengan kondisi sosial ekonomi 25% terendah di daerah pelaksanaan terdaftar di DTKS.',
                'syarat_dokumen' => ['Kartu Keluarga Sejahtera (KKS)', 'KTP-el Asli'],
                'besaran_bantuan' => 'Saldo Bansos Pangan Senilai Rp 200.000 / Bulan',
                'kuota_penerima' => 195,
                'tahun_anggaran' => 2026,
                'status' => 'penyaluran',
                'keterangan' => 'Dapat dibelanjakan komoditas beras, telur, dan bahan pokok di e-Warong / Agen Resmi BUMDes Kencana.',
                'penanggung_jawab' => 'BUMDes Kencana & Kasi Kesra',
            ],
            [
                'nama_program' => 'Bantuan Sarana Pupuk Bersubsidi & Bibit Tani',
                'kategori' => 'pertanian_pupuk',
                'sumber_dana' => 'Ketahanan Pangan Dana Desa 20% & Disperta Sumenep',
                'kriteria_penerima' => 'Petani terdaftar e-Alokasi Simluhtan dan tergabung dalam Kelompok Tani (Poktan) 5 Dusun.',
                'syarat_dokumen' => ['KTP Petani', 'Kartu Tani / e-KTP Terdaftar', 'SPPT Lahan Garapan'],
                'besaran_bantuan' => 'Alokasi Pupuk NPK Phonska & Urea Bersubsidi serta Bibit Unggul',
                'kuota_penerima' => 175,
                'tahun_anggaran' => 2026,
                'status' => 'penyaluran',
                'keterangan' => 'Pengambilan saprotan melalui unit usaha tani BUMDes Kencana Rombiya Barat.',
                'penanggung_jawab' => 'Pengurus BUMDes Kencana & Ketua Poktan',
            ],
        ];

        $savedPrograms = [];
        foreach ($bantuanList as $bantuan) {
            $saved = ProgramBantuan::updateOrCreate(
                ['nama_program' => $bantuan['nama_program']],
                $bantuan
            );
            $savedPrograms[$bantuan['kategori']] = $saved;
        }

        // 3. Data Penerima Bantuan Sosial (KPM) Realistis per Dusun
        $penerimaList = [
            // Dusun Kebunan (Warga akun terdaftar)
            [
                'program_bantuan_id' => $savedPrograms['beras_cbp']->id ?? null,
                'user_id' => $warga?->id,
                'nik' => $warga?->nik ?? '3529012304950001',
                'nama_penerima' => $warga?->name ?? 'Budi Santoso',
                'dusun' => 'Dusun Kebunan',
                'alamat_detail' => 'RT 002 RW 002 Dusun Kebunan',
                'jenis_bansos' => 'Bantuan Cadangan Beras Pemerintah (CBP 10 Kg)',
                'rincian_yang_diterima' => '10 Kg Beras Medium Bulog + Minyak Goreng 1 Liter',
                'periode' => 'Tahap 1 - 2026 (Maret 2026)',
                'status_penyaluran' => 'siap_diambil',
                'tanggal_penyaluran' => now()->addDays(2),
                'lokasi_pengambilan' => 'Kantor Balai Desa Rombiya Barat (Meja Dusun Kebunan)',
                'foto_dokumen_daftar' => 'images/balai_desa.jpeg',
                'catatan' => 'Bawa KTP asli dan Kartu Keluarga asli saat pengambilan di Balai Desa.',
            ],
            [
                'program_bantuan_id' => $savedPrograms['blt_dana_desa']->id ?? null,
                'user_id' => $warga?->id,
                'nik' => $warga?->nik ?? '3529012304950001',
                'nama_penerima' => $warga?->name ?? 'Budi Santoso',
                'dusun' => 'Dusun Kebunan',
                'alamat_detail' => 'RT 002 RW 002 Dusun Kebunan',
                'jenis_bansos' => 'BLT Dana Desa (BLT-DD) 2026',
                'rincian_yang_diterima' => 'Uang Tunai Rp 300.000 / Bulan (Triwulan 1 = Rp 900.000)',
                'periode' => 'Triwulan 1 (Januari - Maret 2026)',
                'status_penyaluran' => 'siap_diambil',
                'tanggal_penyaluran' => now()->addDays(3),
                'lokasi_pengambilan' => 'Kantor Balai Desa Rombiya Barat',
                'foto_dokumen_daftar' => 'images/balai_desa.jpeg',
                'catatan' => 'Penetapan melalui Musyawarah Desa Khusus (Musdesus).',
            ],
            // Dusun Buwa - Penerima Lansia & Beras CBP
            [
                'program_bantuan_id' => $savedPrograms['bansos_lansia']->id ?? null,
                'user_id' => null,
                'nik' => '3529015506480002',
                'nama_penerima' => 'Nenek Siti Maryam',
                'dusun' => 'Dusun Buwa',
                'alamat_detail' => 'RT 001 RW 001 Dusun Buwa',
                'jenis_bansos' => 'Bansos Lansia & Disabilitas (PKH Plus)',
                'rincian_yang_diterima' => 'Bantuan Tunai Lansia Rp 600.000 / Triwulan + Paket Nutrisi Lansia',
                'periode' => 'Tahap 1 - 2026',
                'status_penyaluran' => 'siap_diambil',
                'tanggal_penyaluran' => now()->addDays(2),
                'lokasi_pengambilan' => 'Kantor Balai Desa Rombiya Barat (Layanan Antar Kasun Buwa bagi yang sakit)',
                'foto_dokumen_daftar' => 'images/balai_desa.jpeg',
                'catatan' => 'Dapat diantar langsung ke rumah oleh Kasun Buwa jika penerima berhalangan hadir karena faktor usia.',
            ],
            [
                'program_bantuan_id' => $savedPrograms['beras_cbp']->id ?? null,
                'user_id' => null,
                'nik' => '3529011208750003',
                'nama_penerima' => 'Moh. Hasan',
                'dusun' => 'Dusun Buwa',
                'alamat_detail' => 'RT 003 RW 001 Dusun Buwa',
                'jenis_bansos' => 'Bantuan Cadangan Beras Pemerintah (CBP 10 Kg)',
                'rincian_yang_diterima' => '10 Kg Beras Medium Bulog',
                'periode' => 'Tahap 1 - 2026 (Maret 2026)',
                'status_penyaluran' => 'sudah_diterima',
                'tanggal_penyaluran' => now()->subDays(4),
                'lokasi_pengambilan' => 'Kantor Balai Desa Rombiya Barat',
                'foto_dokumen_daftar' => 'images/balai_desa.jpeg',
                'catatan' => 'Telah diserahterimakan pada tanggal ' . now()->subDays(4)->format('d M Y') . '.',
            ],
            // Dusun Tanodung - Pupuk & PKH
            [
                'program_bantuan_id' => $savedPrograms['pertanian_pupuk']->id ?? null,
                'user_id' => null,
                'nik' => '3529011503820004',
                'nama_penerima' => 'Ahmad Subandi',
                'dusun' => 'Dusun Tanodung',
                'alamat_detail' => 'RT 002 RW 003 Dusun Tanodung',
                'jenis_bansos' => 'Bantuan Sarana Pupuk Bersubsidi & Bibit Tani',
                'rincian_yang_diterima' => '2 Karung Pupuk NPK Phonska Subsidi (100 Kg) + 1 Kantong Benih Jagung Hibrida',
                'periode' => 'Musim Tanam 1 - 2026',
                'status_penyaluran' => 'siap_diambil',
                'tanggal_penyaluran' => now()->addDays(1),
                'lokasi_pengambilan' => 'Gudang Unit Saprotan BUMDes Kencana (Balai Desa)',
                'foto_dokumen_daftar' => 'images/balai_desa.jpeg',
                'catatan' => 'Membawa Kartu Tani / KTP dan bukti keanggotaan Poktan Tanodung.',
            ],
            // Dusun Rombiya - PKH Ibu Hamil/Anak Sekolah & BPNT
            [
                'program_bantuan_id' => $savedPrograms['pkh']->id ?? null,
                'user_id' => null,
                'nik' => '3529014809910005',
                'nama_penerima' => 'Nurul Hidayati',
                'dusun' => 'Dusun Rombiya',
                'alamat_detail' => 'RT 001 RW 002 Dusun Rombiya',
                'jenis_bansos' => 'Program Keluarga Harapan (PKH)',
                'rincian_yang_diterima' => 'Bantuan Tunai PKH Rp 750.000 (Komponen Ibu Hamil & Balita)',
                'periode' => 'Tahap 1 - Triwulan 1 2026',
                'status_penyaluran' => 'sudah_diterima',
                'tanggal_penyaluran' => now()->subDays(2),
                'lokasi_pengambilan' => 'Bank BRI Unit Ganding / Agen BRILink BUMDes',
                'foto_dokumen_daftar' => 'images/balai_desa.jpeg',
                'catatan' => 'Pencairan lancar melalui Kartu KKS Himbara.',
            ],
            [
                'program_bantuan_id' => $savedPrograms['bpnt_sembako']->id ?? null,
                'user_id' => null,
                'nik' => '3529012805870006',
                'nama_penerima' => 'Slamet Riyadi',
                'dusun' => 'Dusun Rombiya',
                'alamat_detail' => 'RT 003 RW 002 Dusun Rombiya',
                'jenis_bansos' => 'BPNT / Program Sembako',
                'rincian_yang_diterima' => 'Paket Sembako Pangan (Beras 10 Kg, Telur 1 Kg, Minyak Goreng 2L, Gula 1 Kg)',
                'periode' => 'Bulan Maret 2026',
                'status_penyaluran' => 'siap_diambil',
                'tanggal_penyaluran' => now()->addDays(2),
                'lokasi_pengambilan' => 'e-Warong BUMDes Kencana Rombiya Barat',
                'foto_dokumen_daftar' => 'images/balai_desa.jpeg',
                'catatan' => 'Bawa Kartu KKS dan KTP asli saat bertransaksi di e-Warong.',
            ],
            // Dusun Kalampok - BLT Dana Desa & Beras CBP
            [
                'program_bantuan_id' => $savedPrograms['blt_dana_desa']->id ?? null,
                'user_id' => null,
                'nik' => '3529010411780007',
                'nama_penerima' => 'Zubairi',
                'dusun' => 'Dusun Kalampok',
                'alamat_detail' => 'RT 002 RW 001 Dusun Kalampok',
                'jenis_bansos' => 'BLT Dana Desa (BLT-DD) 2026',
                'rincian_yang_diterima' => 'Uang Tunai Rp 300.000 / Bulan (Tahap 1 = Rp 900.000)',
                'periode' => 'Triwulan 1 (Januari - Maret 2026)',
                'status_penyaluran' => 'siap_diambil',
                'tanggal_penyaluran' => now()->addDays(3),
                'lokasi_pengambilan' => 'Kantor Balai Desa Rombiya Barat',
                'foto_dokumen_daftar' => 'images/balai_desa.jpeg',
                'catatan' => 'Membawa KTP asli dan KK.',
            ],
        ];

        foreach ($penerimaList as $penerima) {
            PenerimaBantuan::updateOrCreate(
                ['nik' => $penerima['nik'], 'jenis_bansos' => $penerima['jenis_bansos'], 'periode' => $penerima['periode']],
                $penerima
            );
        }

        // 4. Berita & Agenda Desa
        $beritaList = [
            [
                'judul' => 'Musrenbangdes Rombiya Barat: Prioritaskan Rabat Beton Jalan Antar-Dusun dan Pompa Air Pertanian',
                'slug' => 'musrenbangdes-prioritas-jalan-dan-pertanian-2026',
                'kategori' => 'berita',
                'ringkasan' => 'DESA ROMBIYA Barat bersama BPD dan tokoh masyarakat 5 dusun menyepakati fokus pembangunan jalan rabat beton dan penguatan irigasi pertanian.',
                'konten' => "DESA ROMBIYA Barat, Kecamatan Ganding, Kabupaten Sumenep menggelar Musyawarah Perencanaan Pembangunan Desa (Musrenbangdes) di Balai Desa Rombiya Barat.\n\nKepala Desa Rombiya Barat, Farhah, menegaskan bahwa usulan prioritas dari Dusun Kebunan, Buwa, Tanodung, Rombiya, dan Kalampok berpusat pada perbaikan akses jalan tani rabat beton serta pengadaan sarana irigasi pompa air sawah guna mendukung musim tanam tembakau dan tanaman pangan.\n\n\"Kami berkomitmen agar alokasi Dana Desa benar-benar menjawab kebutuhan riil masyarakat petani dan meningkatkan konektivitas antar dusun,\" ungkap Kepala Desa.",
                'gambar_cover' => null,
                'penulis_id' => $admin?->id,
                'is_published' => true,
                'views' => 142,
                'published_at' => now()->subDays(3),
            ],
            [
                'judul' => 'Jadwal Posyandu Terpadu Balita dan Lansia di 5 Dusun Desa Rombiya Barat Bulan Ini',
                'slug' => 'jadwal-posyandu-terpadu-5-dusun-bulan-ini',
                'kategori' => 'posyandu',
                'ringkasan' => 'Simak jadwal dan lokasi penimbangan balita, imunisasi rutin, serta pemeriksaan kesehatan lansia di 5 Dusun.',
                'konten' => "Puskesmas Pembantu bersama Kader Posyandu Desa Rombiya Barat mengumumkan jadwal pelayanan Posyandu Terpadu untuk bulan ini sebagai berikut:\n\n1. Posyandu Dusun Kebunan: Setiap tanggal 5 (Rumah Kasun Kebunan)\n2. Posyandu Dusun Buwa: Setiap tanggal 8 (Poskesdes Buwa)\n3. Posyandu Dusun Tanodung: Setiap tanggal 12 (Balai RT 03 Tanodung)\n4. Posyandu Dusun Rombiya: Setiap tanggal 16 (Halaman RA Sumber Mas)\n5. Posyandu Dusun Kalampok: Setiap tanggal 20 (Rumah Kasun Kalampok)\n\nLayanan meliputi penimbangan berat badan, pengukuran tinggi badan balita, imunisasi lengkap, serta pembagian PMT (Pemberian Makanan Tambahan).",
                'gambar_cover' => null,
                'penulis_id' => $admin?->id,
                'is_published' => true,
                'views' => 98,
                'published_at' => now()->subDays(6),
            ],
            [
                'judul' => 'BUMDes Kencana Rombiya Barat Buka Layanan Distribusi Saprotan dan Agen Pembayaran Resmi',
                'slug' => 'bumdes-kencana-buka-layanan-saprotan-dan-pembayaran',
                'kategori' => 'bumdes',
                'ringkasan' => 'BUMDes Kencana memperluas unit usaha untuk mempermudah petani mendapatkan sarana produksi tani dan pembayaran listrik/air.',
                'konten' => "Badan Usaha Milik Desa (BUMDes) Kencana Desa Rombiya Barat, Kecamatan Ganding kini resmi mengoperasikan unit penyedia Saprotan (Sarana Produksi Pertanian) dan agen pembayaran digital.\n\nUnit ini bertujuan mempermudah petani di 5 dusun dalam memperoleh pupuk, benih unggul jagung dan tembakau, serta melayani pembayaran tagihan listrik, BPJS, dan transfer perbankan tanpa harus menempuh jarak jauh ke pusat kecamatan.",
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

        // 5. Contoh Pengaduan Warga Sampel
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
