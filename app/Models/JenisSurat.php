<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSurat extends Model
{
    use HasFactory;

    protected $table = 'jenis_surat';

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'estimasi_waktu',
        'syarat',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'syarat' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function permohonanSurat(): HasMany
    {
        return $this->hasMany(PermohonanSurat::class, 'jenis_surat_id');
    }
}
