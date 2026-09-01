<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    use HasFactory;

    protected $table = 'profil_desa';

    protected $fillable = [
        'nama_desa',
        'kepala_desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'sejarah',
        'visi_misi',
        'dusun_list',
        'potensi_desa',
        'kontak',
        'jam_operasional',
        'statistik',
    ];

    protected function casts(): array
    {
        return [
            'dusun_list' => 'array',
            'potensi_desa' => 'array',
            'kontak' => 'array',
            'jam_operasional' => 'array',
            'statistik' => 'array',
        ];
    }
}
