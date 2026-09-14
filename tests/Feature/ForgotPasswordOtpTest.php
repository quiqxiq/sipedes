<?php

namespace Tests\Feature;

use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Mockery\MockInterface;
use Tests\TestCase;

class ForgotPasswordOtpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed templates jika dibutuhkan
        $this->seed(\Database\Seeders\WhatsAppTemplateSeeder::class);
    }

    public function test_login_page_renders_with_auth_layout_and_has_forgot_password_link(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Masuk Akun Warga');
        $response->assertSee('Lupa Kata Sandi?');
        $response->assertSee('Kembali ke Beranda');
        // Tidak menampilkan navbar landing page
        $response->assertDontSee('Layanan Surat Online');
        $response->assertDontSee('Kantor Balai Desa Rombiya Barat');
    }

    public function test_register_page_renders_with_auth_layout(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Daftar Akun Warga Baru');
        $response->assertSee('Kembali ke Beranda');
        $response->assertDontSee('Layanan Surat Online');
    }

    public function test_forgot_password_page_renders(): void
    {
        $response = $this->get('/lupa-password');

        $response->assertStatus(200);
        $response->assertSee('Lupa Kata Sandi');
        $response->assertSee('Kirim Kode OTP WhatsApp');
        $response->assertSee('Kembali ke Beranda');
    }

    public function test_send_otp_with_nonexistent_nik_fails(): void
    {
        $response = $this->post('/lupa-password', [
            'nik' => '9999999999999999',
        ]);

        $response->assertSessionHasErrors(['nik']);
    }

    public function test_send_otp_with_valid_nik_creates_otp_and_redirects_to_verify(): void
    {
        $user = User::factory()->create([
            'nik' => '3529100101900001',
            'telepon' => '087880433119',
            'role' => 'warga',
            'is_active' => true,
        ]);

        $this->mock(WhatsAppService::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('sendTemplate')
                ->once()
                ->andReturn(true);
        });

        $response = $this->post('/lupa-password', [
            'nik' => '3529100101900001',
        ]);

        $response->assertRedirect('/lupa-password/verifikasi');
        $response->assertSessionHas('password_reset_user_id', $user->id);

        $this->assertDatabaseHas('password_reset_otps', [
            'user_id' => $user->id,
            'nik' => '3529100101900001',
            'is_used' => false,
        ]);
    }

    public function test_verify_otp_with_invalid_code_fails(): void
    {
        $user = User::factory()->create([
            'nik' => '3529100101900002',
            'telepon' => '087880433119',
        ]);

        $otp = PasswordResetOtp::create([
            'user_id' => $user->id,
            'nik' => $user->nik,
            'telepon' => $user->telepon,
            'otp' => '123456',
            'attempts' => 0,
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->withSession([
            'password_reset_user_id' => $user->id,
            'password_reset_nik' => $user->nik,
        ])->post('/lupa-password/verifikasi', [
            'otp' => '999999',
        ]);

        $response->assertSessionHasErrors(['otp']);
        $this->assertEquals(1, $otp->fresh()->attempts);
    }

    public function test_verify_otp_with_valid_code_redirects_to_reset_form(): void
    {
        $user = User::factory()->create([
            'nik' => '3529100101900003',
            'telepon' => '087880433119',
        ]);

        PasswordResetOtp::create([
            'user_id' => $user->id,
            'nik' => $user->nik,
            'telepon' => $user->telepon,
            'otp' => '654321',
            'attempts' => 0,
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->withSession([
            'password_reset_user_id' => $user->id,
            'password_reset_nik' => $user->nik,
        ])->post('/lupa-password/verifikasi', [
            'otp' => '654321',
        ]);

        $response->assertRedirect('/lupa-password/reset');
        $response->assertSessionHas('password_reset_otp_verified', true);
    }

    public function test_reset_password_updates_user_password_and_redirects_to_login(): void
    {
        $user = User::factory()->create([
            'nik' => '3529100101900004',
            'telepon' => '087880433119',
            'password' => Hash::make('oldpassword123'),
        ]);

        $otp = PasswordResetOtp::create([
            'user_id' => $user->id,
            'nik' => $user->nik,
            'telepon' => $user->telepon,
            'otp' => '112233',
            'attempts' => 0,
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        $this->mock(WhatsAppService::class, function (MockInterface $mock) {
            $mock->shouldReceive('sendTemplate')->andReturn(true);
        });

        $response = $this->withSession([
            'password_reset_user_id' => $user->id,
            'password_reset_otp_verified' => true,
        ])->post('/lupa-password/reset', [
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
        $this->assertTrue($otp->fresh()->is_used);
    }

    public function test_cannot_access_reset_form_without_verified_otp(): void
    {
        $response = $this->get('/lupa-password/reset');

        $response->assertRedirect('/lupa-password');
        $response->assertSessionHas('error');
    }

    public function test_login_with_registered_nik_and_wrong_password_shows_error_on_password_field(): void
    {
        $user = User::factory()->create([
            'nik' => '3529100101900005',
            'password' => Hash::make('correctpassword123'),
        ]);

        $response = $this->post('/login', [
            'nik' => '3529100101900005',
            'password' => 'wrongpassword123',
        ]);

        $response->assertSessionHasErrors('password');
        $response->assertSessionDoesntHaveErrors('nik');
        $this->assertGuest();
    }

    public function test_login_with_unregistered_nik_shows_error_on_nik_field(): void
    {
        $response = $this->post('/login', [
            'nik' => '3529100101999999',
            'password' => 'anyPassword123',
        ]);

        $response->assertSessionHasErrors('nik');
        $response->assertSessionDoesntHaveErrors('password');
        $this->assertGuest();
    }
}
