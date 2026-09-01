<?php

namespace Database\Seeders;

use App\Models\ProfilDesa;
use Illuminate\Database\Seeder;

class ProfilDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProfilDesa::updateOrCreate(
            ['id' => 1],
            [
                'nama_desa' => 'Desa Rombiyah Barat',
                'kepala_desa' => 'Farhah',
                'kecamatan' => 'Ganding',
                'kabupaten' => 'Sumenep',
                'provinsi' => 'Jawa Timur',
                'kode_pos' => '69462',
                'sejarah' => 'Desa Rombiyah Barat (Rombiya Barat) merupakan salah satu desa di wilayah Kecamatan Ganding, Kabupaten Sumenep, Madura, Jawa Timur. Desa ini memiliki tanah pertanian dan perkebunan yang subur dengan komoditas unggulan tembakau Madura, jagung, padi, dan olahan singkong, serta masyarakat yang menjunjung tinggi nilai gotong royong dan kearifan lokal keagamaan.',
                'visi_misi' => "VISI:\nTerwujudnya Tata Kelola Pemerintahan dan Pelayanan Publik Desa Rombiyah Barat yang Maju, Transparan, Adil, Sejahtera, dan Berbasis Digital Terpadu.\n\nMISI:\n1. Menyelenggarakan pelayanan administrasi dan persuratan desa yang cepat, transparan, dan bebas pungli.\n2. Mengoptimalkan pelayanan aspirasi dan pengaduan masyarakat di seluruh 5 dusun secara responsif.\n3. Meningkatkan kesejahteraan ekonomi warga melalui BUMDes Kencana dan pemberdayaan sektor pertanian tembakau & pangan.\n4. Mendorong transparansi penyaluran bantuan sosial (BLT-DD) dan pencegahan stunting melalui posyandu terintegrasi.",
                'dusun_list' => [
                    ['nama' => 'Dusun Kebunan', 'kasun' => 'Kasun Kebunan', 'jumlah_rt' => 4, 'deskripsi' => 'Sentra pertanian tanaman pangan dan perkebunan tembakau'],
                    ['nama' => 'Dusun Buwa', 'kasun' => 'Kasun Buwa', 'jumlah_rt' => 3, 'deskripsi' => 'Wilayah pemukiman dan pertanian hortikultura'],
                    ['nama' => 'Dusun Tanodung', 'kasun' => 'Kasun Tanodung', 'jumlah_rt' => 4, 'deskripsi' => 'Kawasan budidaya tanaman pangan dan peternakan rakyat'],
                    ['nama' => 'Dusun Rombiya', 'kasun' => 'Kasun Rombiya', 'jumlah_rt' => 4, 'deskripsi' => 'Pusat kegiatan masyarakat dan sarana pendidikan'],
                    ['nama' => 'Dusun Kalampok', 'kasun' => 'Kasun Kalampok', 'jumlah_rt' => 5, 'deskripsi' => 'Wilayah perkebunan dan sentra UMKM olahan singkong'],
                ],
                'potensi_desa' => [
                    'pertanian' => 'Pertanian Tembakau Madura, Padi, Jagung, dan Singkong (~298 Ha)',
                    'peternakan' => 'Peternakan Sapi Madura dan Kambing',
                    'umkm' => 'Keripik Singkong TTG, Makanan Olahan Tradisional, Kerajinan',
                    'bumdes' => 'BUMDes Kencana (Perdagangan, Saprotan Pupuk, dan Jasa Desa)',
                ],
                'kontak' => [
                    'telepon' => '082334567890',
                    'whatsapp' => '082334567890',
                    'email' => 'pelayanan@rombiyahbarat.desa.id',
                    'alamat_kantor' => 'Jl. Raya Ganding - Rombiyah Barat No. 01, Kec. Ganding, Kab. Sumenep, Jawa Timur 69462',
                ],
                'jam_operasional' => [
                    'Senin - Kamis' => '08:00 - 15:00 WIB',
                    'Jumat' => '08:00 - 11:30 WIB',
                    'Sabtu - Minggu' => 'Libur (Layanan Online 24 Jam)',
                ],
                'statistik' => [
                    'jumlah_penduduk' => 4820,
                    'jumlah_kk' => 1420,
                    'jumlah_dusun' => 5,
                    'jumlah_rt' => 20,
                    'jumlah_rw' => 5,
                ],
            ]
        );
    }
}
