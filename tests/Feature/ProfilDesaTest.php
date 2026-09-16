<?php

namespace Tests\Feature;

use App\Models\ProfilDesa;
use App\Models\User;
use Database\Seeders\ProfilDesaSeeder;
use Database\Seeders\JenisSuratSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilDesaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ProfilDesaSeeder::class);
        $this->seed(JenisSuratSeeder::class);
    }

    public function test_landing_page_renders_profil_desa_data_from_seeder(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // Identitas Desa
        $response->assertSee('Desa Rombiya Barat');
        $response->assertSee('Ganding');
        $response->assertSee('Sumenep');
        $response->assertSee('Farhah');

        // Sejarah & Visi Misi
        $response->assertSee('Kilas Sejarah & Geografis');
        $response->assertSee('Visi &amp; Misi Pembangunan Desa', false);
        $response->assertSee('Terwujudnya Tata Kelola Pemerintahan');

        // Daftar Dusun
        $response->assertSee('Dusun Kebunan');
        $response->assertSee('Dusun Buwa');
        $response->assertSee('Dusun Tanodung');
        $response->assertSee('Dusun Rombiya');
        $response->assertSee('Dusun Kalampok');

        // Potensi Desa
        $response->assertSee('Pertanian Tembakau Madura');
        $response->assertSee('BUMDes Kencana');

        // Statistik Kependudukan
        $response->assertSee('1.403');
        $response->assertSee('652 L');
        $response->assertSee('751 P');
        $response->assertSee('560');

        // Kontak & Jam Operasional
        $response->assertSee('082334567890');
        $response->assertSee('08:00 - 15:00 WIB');
    }

    public function test_landing_page_dynamically_reflects_updated_profil_desa(): void
    {
        $profil = ProfilDesa::first();
        $profil->update([
            'nama_desa' => 'Rombiya Gemilang',
            'kepala_desa' => 'Bapak Kepala Baru S.Sos',
            'sejarah' => 'Sejarah baru desa mandiri dan berdaya saing tinggi.',
            'visi_misi' => "VISI:\nMenjadi Desa Terdepan Berbasis Inovasi.\n\nMISI:\n1. Pelayanan 100% digital.",
            'dusun_list' => [
                ['nama' => 'Dusun Sentosa', 'kasun' => 'Kasun Sentosa', 'jumlah_rt' => 6, 'deskripsi' => 'Kawasan agrowisata modern'],
                ['nama' => 'Dusun Makmur', 'kasun' => 'Kasun Makmur', 'jumlah_rt' => 5, 'deskripsi' => 'Sentra industri kreatif desa'],
            ],
            'potensi_desa' => [
                'agrowisata' => 'Agrowisata Petik Buah & Wisata Alam Pegunungan',
                'energi' => 'Pengembangan Bioenergi & Panel Surya Mandiri',
            ],
            'statistik' => [
                'jumlah_penduduk' => 2500,
                'jumlah_penduduk_max' => 2600,
                'jumlah_laki_laki' => 1200,
                'jumlah_perempuan' => 1300,
                'jumlah_kk' => 800,
                'jumlah_dusun' => 2,
                'jumlah_rt' => 11,
                'jumlah_rw' => 3,
                'sumber_data' => 'Sensus Mandiri Digital 2026',
            ],
            'kontak' => [
                'whatsapp' => '081299998888',
                'alamat_kantor' => 'Jl. Merdeka Digital No. 99, Rombiya Gemilang',
            ],
            'jam_operasional' => [
                'Senin - Jumat' => '07:30 - 16:00 WIB',
                'Sabtu' => '08:00 - 12:00 WIB',
            ],
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        // Data terupdate harus langsung tampil
        $response->assertSee('Rombiya Gemilang');
        $response->assertSee('Bapak Kepala Baru S.Sos');
        $response->assertSee('Sejarah baru desa mandiri');
        $response->assertSee('Menjadi Desa Terdepan Berbasis Inovasi');
        $response->assertSee('Pelayanan 100% digital');

        // Dusun baru
        $response->assertSee('Dusun Sentosa');
        $response->assertSee('Dusun Makmur');
        $response->assertSee('6 RT');

        // Potensi baru
        $response->assertSee('Agrowisata Petik Buah');
        $response->assertSee('Pengembangan Bioenergi');

        // Statistik baru
        $response->assertSee('2.500');
        $response->assertSee('1.200 L');
        $response->assertSee('1.300 P');
        $response->assertSee('800');
        $response->assertSee('Sensus Mandiri Digital 2026');

        // Kontak & Jam Operasional baru
        $response->assertSee('081299998888');
        $response->assertSee('Jl. Merdeka Digital No. 99');
        $response->assertSee('07:30 - 16:00 WIB');
    }

    public function test_admin_and_petugas_can_access_filament_profil_desa(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->actingAs($admin);
        $this->assertTrue(\App\Filament\Resources\ProfilDesaResource::canAccess());

        $petugas = User::factory()->create([
            'role' => 'petugas',
            'is_active' => true,
        ]);

        $this->actingAs($petugas);
        $this->assertTrue(\App\Filament\Resources\ProfilDesaResource::canAccess());

        $warga = User::factory()->create([
            'role' => 'warga',
            'is_active' => true,
        ]);

        $this->actingAs($warga);
        $this->assertFalse(\App\Filament\Resources\ProfilDesaResource::canAccess());
    }

    public function test_cannot_create_multiple_profil_desa_records(): void
    {
        // Karena di setUp sudah ada 1 record dari ProfilDesaSeeder
        $this->assertEquals(1, ProfilDesa::count());
        $this->assertFalse(\App\Filament\Resources\ProfilDesaResource::canCreate());
    }
}
