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
        'kecamatan',
        'kabupaten',
        'provinsi',
        'sejarah',
        'visi_misi',
        'kontak',
        'jam_operasional',
        'statistik',
    ];

    protected function casts(): array
    {
        return [
            'kontak' => 'array',
            'jam_operasional' => 'array',
            'statistik' => 'array',
        ];
    }
}
