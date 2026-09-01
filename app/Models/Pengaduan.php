<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'user_id',
        'kode_tiket',
        'kategori',
        'dusun',
        'judul',
        'deskripsi',
        'lokasi_detail',
        'foto_lampiran',
        'status',
        'tanggapan_petugas',
        'petugas_id',
        'ditanggapi_at',
    ];

    protected function casts(): array
    {
        return [
            'ditanggapi_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'pertanian_irigasi' => 'Pertanian & Irigasi / Pupuk',
            'jalan_infrastruktur' => 'Jalan & Infrastruktur Dusun',
            'bansos' => 'Bantuan Sosial & Kesejahteraan',
            'kebersihan_lingkungan' => 'Kebersihan & Lingkungan',
            'pelayanan_desa' => 'Pelayanan Balai Desa',
            default => 'Lainnya',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'amber',
            'diproses' => 'blue',
            'selesai' => 'emerald',
            'ditolak' => 'rose',
            default => 'gray',
        };
    }
}
