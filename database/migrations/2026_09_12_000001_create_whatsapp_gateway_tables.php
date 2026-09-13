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
        Schema::create('whatsapp_templates', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->enum('kategori', ['surat', 'pengaduan', 'sistem'])->default('surat');
            $table->enum('target', ['warga', 'petugas'])->default('warga');
            $table->text('konten');
            $table->json('variabel_tersedia')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('whatsapp_logs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tujuan');
            $table->string('nama_penerima')->nullable();
            $table->string('tipe_pesan')->default('surat'); // surat, pengaduan, sistem, uji_coba
            $table->unsignedBigInteger('referensi_id')->nullable();
            $table->text('pesan');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->json('response_payload')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_logs');
        Schema::dropIfExists('whatsapp_templates');
    }
};
