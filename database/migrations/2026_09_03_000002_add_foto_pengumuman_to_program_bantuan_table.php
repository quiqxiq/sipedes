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
        Schema::table('program_bantuan', function (Blueprint $table) {
            $table->json('foto_pengumuman')->nullable()->after('keterangan'); // scan lembar pengumuman / poster
            $table->string('penanggung_jawab')->nullable()->after('foto_pengumuman'); // pamong / kasun pelaksana
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_bantuan', function (Blueprint $table) {
            $table->dropColumn(['foto_pengumuman', 'penanggung_jawab']);
        });
    }
};
