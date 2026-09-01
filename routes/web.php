<?php

use App\Http\Controllers\SuratPdfController;
use App\Http\Controllers\Warga\AuthController;
use App\Http\Controllers\Warga\DashboardController;
use App\Http\Controllers\Warga\LandingController;
use App\Http\Controllers\Warga\PermohonanWargaController;
use App\Livewire\Warga\PengajuanSuratWizard;
use Illuminate\Support\Facades\Route;

// Public Landing Page
Route::get('/', [LandingController::class, 'index'])->name('warga.landing');

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

    // Download PDF Surat Official
    Route::get('/surat/{id}/pdf', [SuratPdfController::class, 'generatePdf'])->name('warga.surat.pdf');
});
