<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('kode_tiket')->unique(); // contoh: LAPOR-2026-0001
            $table->string('kategori'); // pertanian_irigasi, jalan_infrastruktur, bansos, kebersihan_lingkungan, pelayanan_desa, lainnya
            $table->string('dusun'); // Dusun Kebunan, Buwa, Tanodung, Rombiya, Kalampok
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lokasi_detail')->nullable(); // misal: Dekat Lapangan Dusun Kebunan RT 02
            $table->string('foto_lampiran')->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->text('tanggapan_petugas')->nullable();
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('ditanggapi_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
