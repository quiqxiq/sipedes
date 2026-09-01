<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Data warga dari data.md (data kependudukan Desa Rombiyah Barat).
     * Disesuaikan dengan kolom tabel users yang tersedia:
     * - NIK        -> nik
     * - Nama       -> name
     * - Alamat     -> alamat (dusun + RT/RW)
     * - email      -> dibuat unik dari nama (@gmail.com)
     * - telepon    -> tidak ada di data, diisi null
     * - role       -> warga
     * - password   -> default "password" (sama seperti seeder lain)
     *
     * Data lain dari KTP (tempat/tgl lahir, jenis kelamin, agama, status
     * perkawinan, pekerjaan, kewarganegaraan) tidak tersedia sebagai kolom
     * pada tabel users, sehingga tidak di-seed.
     */
    public function run(): void
    {
        $warga = [
            [
                'nik' => '3529102904650001',
                'name' => 'SUHRAWI',
                'alamat' => 'DUSUN KEBUNAN, RT 003 RW 002',
                'email' => 'suhrawi@gmail.com',
            ],
            [
                'nik' => '3529100107430086',
                'name' => 'Moh Sabri',
                'alamat' => 'DUSUN KEBUNAN, RT 001 RW 002',
                'email' => 'mohsabri@gmail.com',
            ],
            [
                'nik' => '3529104307730001',
                'name' => 'BADRIYAH',
                'alamat' => 'DUSUN KEBUNAN, RT 002 RW 002',
                'email' => 'badriyah@gmail.com',
            ],
            [
                'nik' => '3529101807020003',
                'name' => 'KHAIRUL ANAM',
                'alamat' => 'DUSUN KEBUNAN, RT 003 RW 002',
                'email' => 'khairulanam@gmail.com',
            ],
            [
                'nik' => '3529104107540064',
                'name' => 'HIRA',
                'alamat' => 'DUSUN KEBUNAN, RT 003 RW 002',
                'email' => 'hira@gmail.com',
            ],
            [
                'nik' => '3529104107730153',
                'name' => 'MUSLIHAH',
                'alamat' => 'DUSUN BUWA, RT 001 RW 001',
                'email' => 'muslihah@gmail.com',
            ],
            [
                'nik' => '3529100107680167',
                'name' => 'HARIYA',
                'alamat' => 'DUSUN BUWA, RT 001 RW 001',
                'email' => 'hariya@gmail.com',
            ],
            [
                'nik' => '3529104107600210',
                'name' => 'ROKAYYAH',
                'alamat' => 'DUSUN TANODUNG, RT 003 RW 004',
                'email' => 'rokayyah@gmail.com',
            ],
            [
                'nik' => '3529105208020003',
                'name' => 'SYARIFAH',
                'alamat' => 'DUSUN TANODUNG, RT 003 RW 004',
                'email' => 'syarifah@gmail.com',
            ],
            [
                'nik' => '3529104107430162',
                'name' => 'AMRI',
                'alamat' => 'DUSUN ROMBIYA, RT 003 RW 002',
                'email' => 'amri@gmail.com',
            ],
            [
                'nik' => '3529100506040002',
                'name' => 'RIAN MOR HIDAYAT',
                'alamat' => 'DUSUN ROMBIYA, RT 003 RW 003',
                'email' => 'rianmorhidayat@gmail.com',
            ],
            [
                'nik' => '3529104107500168',
                'name' => 'ALMA',
                'alamat' => 'DUSUN KALAMPOK, RT 002 RW 005',
                'email' => 'alma@gmail.com',
            ],
            [
                'nik' => '352910700677004',
                'name' => 'KUTSIYAH',
                'alamat' => 'DUSUN KALAMPOK, RT 002 RW 005',
                'email' => 'kutsiyah@gmail.com',
            ],
            [
                'nik' => '3529104107400015',
                'name' => 'EDJU',
                'alamat' => 'DUSUN TANODUNG, RT 004 RW 004',
                'email' => 'edju@gmail.com',
            ],
            [
                'nik' => '3529102104600002',
                'name' => 'ABD. MUNI',
                'alamat' => 'DUSUN TANODUNG, RT 004 RW 004',
                'email' => 'abdmuni@gmail.com',
            ],
            [
                'nik' => '3529104107420060',
                'name' => 'SUANI',
                'alamat' => 'DUSUN KALAMPOK, RT 002 RW 005',
                'email' => 'suani@gmail.com',
            ],
            [
                'nik' => '3529101504040003',
                'name' => 'MOH ROFIQI',
                'alamat' => 'DUSUN KALAMPOK, RT 001 RW 005',
                'email' => 'mohrofiqi@gmail.com',
            ],
        ];

        foreach ($warga as $data) {
            User::firstOrCreate(
                ['nik' => $data['nik']],
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'telepon' => null,
                    'alamat' => $data['alamat'],
                    'role' => 'warga',
                    'is_active' => true,
                    'password' => Hash::make('password'),
                ]
            );
        }
    }
}
