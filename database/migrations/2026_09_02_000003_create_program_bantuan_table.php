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
        Schema::create('program_bantuan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program'); // contoh: BLT Dana Desa (BLT-DD) 2026
            $table->string('kategori'); // bansos_tunai, pangan_sembako, pertanian_bibit, kesehatan_stunting
            $table->string('sumber_dana'); // Dana Desa (APBDes), APBD Kab. Sumenep, APBN Kemensos
            $table->text('kriteria_penerima');
            $table->json('syarat_dokumen')->nullable(); // KTP, KK, SKTM, dll.
            $table->string('besaran_bantuan')->nullable(); // contoh: Rp 300.000 / bulan atau 10 kg beras
            $table->integer('kuota_penerima')->nullable();
            $table->integer('tahun_anggaran')->default(2026);
            $table->enum('status', ['dibuka', 'proses_seleksi', 'penyaluran', 'selesai'])->default('penyaluran');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_bantuan');
    }
};
