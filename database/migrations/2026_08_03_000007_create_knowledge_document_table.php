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
        Schema::create('knowledge_document', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Uploader/Admin
            $table->string('nama_file');
            $table->string('path')->nullable();
            $table->string('kategori')->nullable(); // e.g. SOP, Perdes, Syarat Surat, Profil Desa
            $table->integer('jumlah_chunks')->default(0);
            $table->boolean('is_indexed')->default(false);
            $table->string('status_indexing')->default('pending'); // pending, processing, indexed, failed
            $table->string('dify_document_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_document');
    }
};
