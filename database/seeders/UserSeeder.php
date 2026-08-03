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
            ['email' => 'admin@rombiyahbarat.desa.id'],
            [
                'name' => 'Administrator Desa',
                'nik' => '3505010101010001',
                'telepon' => '081234567890',
                'alamat' => 'Kantor Desa Rombiyah Barat',
                'role' => 'admin',
                'is_active' => true,
                'password' => Hash::make('password'),
            ]
        );

        // 2. Petugas Desa
        User::firstOrCreate(
            ['email' => 'petugas@rombiyahbarat.desa.id'],
            [
                'name' => 'Petugas Pelayanan Desa',
                'nik' => '3505010202020002',
                'telepon' => '081234567891',
                'alamat' => 'Kantor Desa Rombiyah Barat',
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
                'nik' => '3505011508850003',
                'telepon' => '085712345678',
                'alamat' => 'RT 02 RW 01, Rombiyah Barat',
                'role' => 'warga',
                'is_active' => true,
                'password' => Hash::make('password'),
            ]
        );
    }
}
