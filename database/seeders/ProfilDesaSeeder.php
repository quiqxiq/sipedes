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
                'kecamatan' => 'Gandusari',
                'kabupaten' => 'Blitar',
                'provinsi' => 'Jawa Timur',
                'sejarah' => 'Desa Rombiyah Barat merupakan salah satu desa di wilayah Kecamatan Gandusari yang kaya akan potensi pertanian, perkebunan, dan kearifan lokal. Desa ini terus berkomitmen meningkatkan kualitas pelayanan publik masyarakat secara efisien dan transparan.',
                'visi_misi' => "VISI:\nTerwujudnya Pelayanan Desa Rombiyah Barat yang Maju, Transparan, Akuntabel, dan Berbasis Digital.\n\nMISI:\n1. Meningkatkan kualitas tata kelola pemerintahan desa berbasis teknologi informasi.\n2. Memberikan pelayanan administrasi desa yang cepat, mudah, dan bebas pungli.\n3. Mendorong keterbukaan informasi publik dan partisipasi aktif warga.",
                'kontak' => [
                    'telepon' => '(0342) 123456',
                    'whatsapp' => '081234567890',
                    'email' => 'layanan@rombiyahbarat.desa.id',
                    'alamat_kantor' => 'Jl. Raya Desa Rombiyah Barat No. 01, Kec. Gandusari, Kab. Blitar, Jawa Timur 66187',
                ],
                'jam_operasional' => [
                    'Senin - Kamis' => '08:00 - 15:00 WIB',
                    'Jumat' => '08:00 - 11:30 WIB',
                    'Sabtu - Minggu' => 'Libur',
                ],
                'statistik' => [
                    'jumlah_penduduk' => 4500,
                    'jumlah_kk' => 1350,
                    'jumlah_rt' => 24,
                    'jumlah_rw' => 6,
                ],
            ]
        );
    }
}
