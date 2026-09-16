<?php

namespace Tests\Feature;

use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
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

        $response->assertRedirect(route('warga.password.verify', ['nik' => '3529100101900001']));
        $response->assertSessionHas('password_reset_user_id', $user->id);

        $this->assertDatabaseHas('password_reset_otps', [
            'user_id' => $user->id,
            'nik' => '3529100101900001',
            'is_used' => false,
        ]);
    }

    public function test_submitting_nik_when_otp_recently_sent_redirects_directly_to_verify_page(): void
    {
        $user = User::factory()->create([
            'nik' => '3529100101900003',
            'telepon' => '087880433119',
            'role' => 'warga',
            'is_active' => true,
        ]);

        PasswordResetOtp::create([
            'user_id' => $user->id,
            'nik' => $user->nik,
            'telepon' => $user->telepon,
            'otp' => '123456',
            'attempts' => 0,
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now()->subSeconds(20),
        ]);

        $response = $this->post('/lupa-password', [
            'nik' => '3529100101900003',
        ]);

        // Harus langsung diarahkan ke halaman verifikasi OTP, tidak terjebak di input NIK
        $response->assertRedirect(route('warga.password.verify', ['nik' => '3529100101900003']));
        $response->assertSessionHas('password_reset_user_id', $user->id);
    }

    public function test_visiting_forgot_password_while_having_active_otp_redirects_to_verify(): void
    {
        $user = User::factory()->create([
            'nik' => '3529100101900004',
            'telepon' => '087880433119',
            'role' => 'warga',
            'is_active' => true,
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
        ])->get('/lupa-password');

        $response->assertRedirect(route('warga.password.verify', ['nik' => $user->nik]));
    }

    public function test_visiting_forgot_password_with_ganti_flag_clears_session(): void
    {
        $response = $this->withSession([
            'password_reset_user_id' => 999,
            'password_reset_nik' => '3529100101900004',
        ])->get('/lupa-password?ganti=1');

        $response->assertStatus(200);
        $response->assertSee('Lupa Kata Sandi');
        $response->assertSessionMissing('password_reset_user_id');
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

        $response->assertRedirectContains('/lupa-password/reset');
        $response->assertSessionHas('password_reset_otp_verified', true);
        $response->assertSessionHas('password_reset_token');
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
        $this->assertFalse(Auth::check());
    }

    public function test_reset_password_logs_out_any_active_login_and_redirects_to_login(): void
    {
        $user = User::factory()->create([
            'nik' => '3529100101900099',
            'telepon' => '087880433119',
            'password' => Hash::make('oldpassword123'),
        ]);

        $otp = PasswordResetOtp::create([
            'user_id' => $user->id,
            'nik' => $user->nik,
            'telepon' => $user->telepon,
            'otp' => '654321',
            'reset_token' => 'token-logged-in-user-999',
            'verified_at' => now(),
            'attempts' => 0,
            'is_used' => false,
            'expires_at' => now()->addMinutes(15),
        ]);

        $this->mock(WhatsAppService::class, function (MockInterface $mock) {
            $mock->shouldReceive('sendTemplate')->andReturn(true);
        });

        // Simulasikan user sedang login sebelumnya
        $response = $this->actingAs($user)
            ->withSession([
                'password_reset_user_id' => $user->id,
                'password_reset_otp_verified' => true,
                'password_reset_token' => 'token-logged-in-user-999',
            ])->post('/lupa-password/reset', [
                'token' => 'token-logged-in-user-999',
                'nik' => $user->nik,
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('success');
        $this->assertFalse(Auth::check());
    }

    public function test_cannot_access_reset_form_without_verified_otp(): void
    {
        $response = $this->get('/lupa-password/reset');

        $response->assertRedirect('/lupa-password');
        $response->assertSessionHas('error');
    }

    public function test_can_access_reset_form_with_verified_token_query_fallback(): void
    {
        $user = User::factory()->create([
            'nik' => '3529100101900088',
            'telepon' => '087880433119',
        ]);

        PasswordResetOtp::create([
            'user_id' => $user->id,
            'nik' => $user->nik,
            'telepon' => $user->telepon,
            'otp' => '112233',
            'reset_token' => 'test-secure-token-12345',
            'verified_at' => now(),
            'attempts' => 0,
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->get('/lupa-password/reset?token=test-secure-token-12345&nik=' . $user->nik);

        $response->assertOk();
        $response->assertSee('Buat Kata Sandi Baru');
        $response->assertSee($user->name);
    }

    public function test_reset_password_with_token_fallback_updates_password_when_session_is_empty(): void
    {
        $user = User::factory()->create([
            'nik' => '3529100101900089',
            'telepon' => '087880433119',
            'password' => Hash::make('oldpassword123'),
        ]);

        $otp = PasswordResetOtp::create([
            'user_id' => $user->id,
            'nik' => $user->nik,
            'telepon' => $user->telepon,
            'otp' => '998877',
            'reset_token' => 'test-token-no-session-999',
            'verified_at' => now(),
            'attempts' => 0,
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        $this->mock(WhatsAppService::class, function (MockInterface $mock) {
            $mock->shouldReceive('sendTemplate')->andReturn(true);
        });

        // Tidak ada session sama sekali, hanya mengandalkan hidden token & nik
        $response = $this->post('/lupa-password/reset', [
            'token' => 'test-token-no-session-999',
            'nik' => $user->nik,
            'password' => 'newsupersecurepassword123',
            'password_confirmation' => 'newsupersecurepassword123',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('newsupersecurepassword123', $user->password));
        $this->assertTrue($otp->fresh()->is_used);
    }

    public function test_reset_password_validation_error_preserves_session_without_rejecting_access(): void
    {
        $user = User::factory()->create([
            'nik' => '3529100101900090',
            'telepon' => '087880433119',
            'password' => Hash::make('oldpassword123'),
        ]);

        PasswordResetOtp::create([
            'user_id' => $user->id,
            'nik' => $user->nik,
            'telepon' => $user->telepon,
            'otp' => '445566',
            'reset_token' => 'test-token-mismatch-888',
            'verified_at' => now(),
            'attempts' => 0,
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Input password confirmation tidak cocok
        $response = $this->withSession([
            'password_reset_user_id' => $user->id,
            'password_reset_nik' => $user->nik,
            'password_reset_token' => 'test-token-mismatch-888',
            'password_reset_otp_verified' => true,
        ])->from('/lupa-password/reset?token=test-token-mismatch-888&nik=' . $user->nik)
          ->post('/lupa-password/reset', [
            'token' => 'test-token-mismatch-888',
            'nik' => $user->nik,
            'password' => 'mismatchpassword123',
            'password_confirmation' => 'differentpassword456',
        ]);

        $response->assertRedirect('/lupa-password/reset?token=test-token-mismatch-888&nik=' . $user->nik);
        $response->assertSessionHasErrors(['password']);
        $response->assertSessionHas('password_reset_otp_verified', true);
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
