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
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->enum('kategori', ['berita', 'pengumuman', 'agenda', 'posyandu', 'bumdes'])->default('berita');
            $table->text('ringkasan')->nullable();
            $table->longText('konten');
            $table->string('gambar_cover')->nullable();
            $table->foreignId('penulis_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_published')->default(true);
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
