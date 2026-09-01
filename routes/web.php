<?php

use App\Http\Controllers\SuratPdfController;
use App\Http\Controllers\Warga\AuthController;
use App\Http\Controllers\Warga\DashboardController;
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

// Protected Warga Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('warga.logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('warga.dashboard');
    Route::get('/pengajuan', PengajuanSuratWizard::class)->name('warga.pengajuan.wizard');
    Route::get('/riwayat', [PermohonanWargaController::class, 'index'])->name('warga.riwayat.index');
    Route::get('/riwayat/{id}', [PermohonanWargaController::class, 'show'])->name('warga.riwayat.show');

    // Layanan Pengaduan & Aspirasi Warga
    Route::get('/lapor', [PengaduanController::class, 'create'])->name('warga.pengaduan.create');
    Route::post('/lapor', [PengaduanController::class, 'store'])->name('warga.pengaduan.store');
    Route::get('/lapor/riwayat', [PengaduanController::class, 'index'])->name('warga.pengaduan.index');
    Route::get('/lapor/{id}', [PengaduanController::class, 'show'])->name('warga.pengaduan.show');

    // Download PDF Surat Official
    Route::get('/surat/{id}/pdf', [SuratPdfController::class, 'generatePdf'])->name('warga.surat.pdf');
});
