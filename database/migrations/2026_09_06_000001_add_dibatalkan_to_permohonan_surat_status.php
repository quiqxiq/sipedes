<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE permohonan_surat MODIFY COLUMN status ENUM('diajukan', 'diproses', 'disetujui', 'ditolak', 'butuh_koreksi', 'dibatalkan') NOT NULL DEFAULT 'diajukan'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE permohonan_surat MODIFY COLUMN status ENUM('diajukan', 'diproses', 'disetujui', 'ditolak', 'butuh_koreksi') NOT NULL DEFAULT 'diajukan'");
        }
    }
};
