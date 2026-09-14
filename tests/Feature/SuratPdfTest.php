<?php

namespace Tests\Feature;

use App\Models\JenisSurat;
use App\Models\PermohonanSurat;
use App\Models\ProfilDesa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuratPdfTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\ProfilDesaSeeder::class);
        $this->seed(\Database\Seeders\JenisSuratSeeder::class);
    }

    public function test_owner_warga_can_download_approved_surat_pdf(): void
    {
        $warga = User::factory()->create([
            'role' => 'warga',
            'name' => 'Budi Santoso',
            'nik' => '3529100101900001',
            'telepon' => '087880433119',
            'alamat' => 'Dusun Kebunan, Desa Rombiya Barat',
        ]);

        $jenisSurat = JenisSurat::where('kode', 'SKTM')->first();

        $permohonan = PermohonanSurat::create([
            'nomor_permohonan' => 'SRT/20260915/00001',
            'user_id' => $warga->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'disetujui',
            'tanggal_selesai' => now(),
            'data_pemohon' => [
                'keperluan' => 'Pendaftaran Beasiswa Anak',
            ],
        ]);

        $response = $this->actingAs($warga)->get(route('warga.surat.pdf', $permohonan->id));

        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('content-type'));
        $this->assertNotEmpty($response->getContent());
    }

    public function test_admin_can_download_any_approved_surat_pdf(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $warga = User::factory()->create([
            'role' => 'warga',
            'name' => 'Ahmad Warga',
        ]);

        $jenisSurat = JenisSurat::where('kode', 'SKU')->first();

        $permohonan = PermohonanSurat::create([
            'nomor_permohonan' => 'SRT/20260915/00002',
            'user_id' => $warga->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'disetujui',
            'tanggal_selesai' => now(),
        ]);

        $response = $this->actingAs($admin)->get(route('warga.surat.pdf', $permohonan->id));

        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('content-type'));
    }

    public function test_other_warga_cannot_download_unowned_surat(): void
    {
        $wargaOwner = User::factory()->create(['role' => 'warga']);
        $wargaOther = User::factory()->create(['role' => 'warga']);

        $jenisSurat = JenisSurat::first();

        $permohonan = PermohonanSurat::create([
            'nomor_permohonan' => 'SRT/20260915/00003',
            'user_id' => $wargaOwner->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'disetujui',
            'tanggal_selesai' => now(),
        ]);

        $response = $this->actingAs($wargaOther)->get(route('warga.surat.pdf', $permohonan->id));

        $response->assertStatus(403);
    }

    public function test_cannot_download_unapproved_surat(): void
    {
        $warga = User::factory()->create(['role' => 'warga']);
        $jenisSurat = JenisSurat::first();

        $permohonan = PermohonanSurat::create([
            'nomor_permohonan' => 'SRT/20260915/00004',
            'user_id' => $warga->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'diajukan',
        ]);

        $response = $this->actingAs($warga)->get(route('warga.surat.pdf', $permohonan->id));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }
}
