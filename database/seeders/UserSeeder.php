<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Administrator
        User::firstOrCreate(
            ['email' => 'admin@rombiyabarat.desa.id'],
            [
                'name' => 'Administrator Desa Rombiya Barat',
                'nik' => '3529100101850001',
                'telepon' => '081234567890',
                'alamat' => 'Kantor Balai Desa Rombiya Barat, Kec. Ganding',
                'role' => 'admin',
                'is_active' => true,
                'password' => Hash::make('password'),
            ]
        );

        // 2. Petugas Desa
        User::firstOrCreate(
            ['email' => 'petugas@rombiyabarat.desa.id'],
            [
                'name' => 'Petugas Pelayanan Desa',
                'nik' => '3529100202900002',
                'telepon' => '081234567891',
                'alamat' => 'Kantor Balai Desa Rombiya Barat, Kec. Ganding',
                'role' => 'petugas',
                'is_active' => true,
                'password' => Hash::make('password'),
            ]
        );

        // 3. Sample Warga
        User::firstOrCreate(
            ['email' => 'warga@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'nik' => '3529101508850003',
                'telepon' => '085712345678',
                'alamat' => 'Dusun Kebunan, RT 002 RW 002, Rombiya Barat',
                'role' => 'warga',
                'is_active' => true,
                'password' => Hash::make('password'),
            ]
        );
    }
}
