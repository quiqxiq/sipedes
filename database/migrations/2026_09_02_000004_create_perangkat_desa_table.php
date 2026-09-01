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
        Schema::create('perangkat_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan'); // Kepala Desa, Sekretaris Desa, Kaur Keuangan, Kasun Kebunan, Kasun Buwa, Kasun Tanodung, Kasun Rombiya, Kasun Kalampok, dll.
            $table->string('wilayah_tugas')->nullable(); // Pusat Desa, Dusun Kebunan, Dusun Buwa, dll.
            $table->string('nip_atau_nomor')->nullable();
            $table->string('foto')->nullable();
            $table->string('telepon')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perangkat_desa');
    }
};
