<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramBantuan extends Model
{
    use HasFactory;

    protected $table = 'program_bantuan';

    protected $fillable = [
        'nama_program',
        'kategori',
        'sumber_dana',
        'kriteria_penerima',
        'syarat_dokumen',
        'besaran_bantuan',
        'kuota_penerima',
        'tahun_anggaran',
        'status',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'syarat_dokumen' => 'array',
            'kuota_penerima' => 'integer',
            'tahun_anggaran' => 'integer',
        ];
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'bansos_tunai' => 'Bansos Tunai (BLT)',
            'pangan_sembako' => 'Bantuan Pangan / Sembako',
            'pertanian_bibit' => 'Bantuan Pertanian & Pupuk',
            'kesehatan_stunting' => 'PMT Gizi & Stunting Balita',
            default => 'Bantuan Sosial',
        };
    }
}
