<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'ringkasan',
        'konten',
        'gambar_cover',
        'penulis_id',
        'is_published',
        'views',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul) . '-' . Str::random(5);
            }
            if (empty($berita->published_at)) {
                $berita->published_at = now();
            }
        });
    }

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'berita' => 'Berita Desa',
            'pengumuman' => 'Pengumuman',
            'agenda' => 'Agenda Desa',
            'posyandu' => 'Jadwal Posyandu',
            'bumdes' => 'BUMDes Kencana',
            default => 'Informasi',
        };
    }
}
