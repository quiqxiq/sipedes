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
        Schema::create('penerima_bantuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_bantuan_id')->nullable()->constrained('program_bantuan')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nik', 16)->index();
            $table->string('nama_penerima');
            $table->string('dusun'); // Dusun Kebunan, Dusun Buwa, Dusun Tanodung, Dusun Rombiya, Dusun Kalampok
            $table->string('alamat_detail')->nullable();
            $table->string('jenis_bansos'); // PKH, Bansos Lansia, BLT Dana Desa, Beras CBP 10 Kg, BPNT / Sembako, dll.
            $table->string('rincian_yang_diterima'); // contoh: 'Beras Bulog 10 Kg + Minyak Goreng 2L' atau 'Uang Tunai Rp 300.000 / bulan'
            $table->string('periode')->default('Tahap 1 - 2026'); // contoh: 'Maret 2026', 'Triwulan 1 2026'
            $table->enum('status_penyaluran', ['terdaftar', 'siap_diambil', 'sudah_diterima', 'dibatalkan'])->default('terdaftar');
            $table->date('tanggal_penyaluran')->nullable();
            $table->string('lokasi_pengambilan')->default('Kantor Balai Desa Rombiya Barat');
            $table->string('foto_dokumen_daftar')->nullable(); // path lampiran foto scan daftar dari pamong
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['dusun', 'status_penyaluran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerima_bantuan');
    }
};
