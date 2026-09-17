<?php

use App\Http\Controllers\SuratPdfController;
use App\Http\Controllers\Warga\AuthController;
use App\Http\Controllers\Warga\DashboardController;
use App\Http\Controllers\Warga\ForgotPasswordController;
use App\Http\Controllers\Warga\InformasiDesaController;
use App\Http\Controllers\Warga\LandingController;
use App\Http\Controllers\Warga\PengaduanController;
use App\Http\Controllers\Warga\PermohonanWargaController;
use App\Livewire\Warga\PengajuanSuratWizard;
use Illuminate\Support\Facades\Route;

// Public Landing Page & Informasi Desa
Route::get('/', [LandingController::class, 'index'])->name('warga.landing');
Route::get('/informasi', [InformasiDesaController::class, 'index'])->name('warga.informasi.index');
Route::get('/bansos', [InformasiDesaController::class, 'bansos'])->name('warga.informasi.bansos');
Route::get('/berita/{slug}', [InformasiDesaController::class, 'beritaDetail'])->name('warga.berita.detail');

// Guest Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('warga.login');
    Route::post('/login', [AuthController::class, 'login'])->name('warga.login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('warga.register');
    Route::post('/register', [AuthController::class, 'register'])->name('warga.register.store');
});

// Alur Lupa Password & Verifikasi OTP WhatsApp
Route::get('/lupa-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('warga.password.request');
Route::post('/lupa-password', [ForgotPasswordController::class, 'sendOtp'])->name('warga.password.send_otp');
Route::get('/lupa-password/verifikasi', [ForgotPasswordController::class, 'showVerifyForm'])->name('warga.password.verify');
Route::post('/lupa-password/verifikasi', [ForgotPasswordController::class, 'verifyOtp'])->name('warga.password.verify_otp');
Route::post('/lupa-password/kirim-ulang', [ForgotPasswordController::class, 'resendOtp'])->name('warga.password.resend');
Route::get('/lupa-password/reset', [ForgotPasswordController::class, 'showResetForm'])->name('warga.password.reset');
Route::post('/lupa-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('warga.password.update');

// Protected Warga Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('warga.logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('warga.dashboard');
    Route::get('/pengajuan', PengajuanSuratWizard::class)->name('warga.pengajuan.wizard');
    Route::get('/riwayat', [PermohonanWargaController::class, 'index'])->name('warga.riwayat.index');
    Route::get('/riwayat/{id}', [PermohonanWargaController::class, 'show'])->name('warga.riwayat.show');
    Route::post('/riwayat/{id}/batal', [PermohonanWargaController::class, 'cancel'])->name('warga.riwayat.cancel');

    // Layanan Pengaduan & Aspirasi Warga
    Route::get('/lapor', [PengaduanController::class, 'create'])->name('warga.pengaduan.create');
    Route::post('/lapor', [PengaduanController::class, 'store'])->name('warga.pengaduan.store');
    Route::get('/lapor/riwayat', [PengaduanController::class, 'index'])->name('warga.pengaduan.index');
    Route::get('/lapor/{id}', [PengaduanController::class, 'show'])->name('warga.pengaduan.show');

    // Download & Preview PDF Surat Official
    Route::get('/surat/{id}/pdf', [SuratPdfController::class, 'generatePdf'])->name('warga.surat.pdf');
    Route::get('/surat/{id}/preview', function ($id) {
        $permohonan = \App\Models\PermohonanSurat::with(['jenisSurat', 'user', 'petugas'])->findOrFail($id);
        $profil = \App\Models\ProfilDesa::first();
        $logoPath = public_path('images/logo.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;
        $tanggalObj = $permohonan->tanggal_selesai ?? $permohonan->updated_at ?? now();
        $tanggalSurat = $tanggalObj->translatedFormat('d F Y');
        $kadesName = !empty($profil?->kepala_desa) ? strtoupper($profil->kepala_desa) : 'FARHAH';

        return view('pdf.surat-template', [
            'permohonan' => $permohonan,
            'profil' => $profil,
            'logoBase64' => $logoBase64,
            'tanggalSurat' => $tanggalSurat,
            'kadesName' => $kadesName,
        ]);
    })->name('warga.surat.preview');
});

if (app()->environment('local')) {
    Route::get('/_screenshot-prep-otp', function () {
        $user = \App\Models\User::where('nik', '3529102904650001')->first();
        if ($user) {
            \App\Models\PasswordResetOtp::where('user_id', $user->id)->delete();
            \App\Models\PasswordResetOtp::create([
                'user_id' => $user->id,
                'nik' => $user->nik,
                'telepon' => $user->telepon,
                'otp' => '123456',
                'reset_token' => 'demo-token-skripsi-2026',
                'verified_at' => now(),
                'is_used' => false,
                'expires_at' => now()->addMinutes(60),
            ]);
            return response()->json(['status' => 'ok']);
        }
        return response()->json(['status' => 'user_not_found'], 404);
    });
}

