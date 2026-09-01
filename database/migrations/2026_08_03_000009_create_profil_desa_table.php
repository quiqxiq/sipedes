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
        Schema::create('profil_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa')->default('Desa Rombiyah Barat');
            $table->string('kepala_desa')->default('Farhah');
            $table->string('kecamatan')->default('Ganding');
            $table->string('kabupaten')->default('Sumenep');
            $table->string('provinsi')->default('Jawa Timur');
            $table->string('kode_pos')->default('69462');
            $table->text('sejarah')->nullable();
            $table->text('visi_misi')->nullable();
            $table->json('dusun_list')->nullable(); // daftar 5 dusun
            $table->json('potensi_desa')->nullable(); // pertanian tembakau, BUMDes, dll
            $table->json('kontak')->nullable(); // telepon, email, alamat_kantor
            $table->json('jam_operasional')->nullable();
            $table->json('statistik')->nullable(); // jumlah_penduduk, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_desa');
    }
};
