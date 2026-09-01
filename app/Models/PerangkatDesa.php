<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerangkatDesa extends Model
{
    use HasFactory;

    protected $table = 'perangkat_desa';

    protected $fillable = [
        'nama',
        'jabatan',
        'wilayah_tugas',
        'nip_atau_nomor',
        'foto',
        'telepon',
        'urutan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'urutan' => 'integer',
        ];
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
                return $this->foto;
            }
            if (str_starts_with($this->foto, 'images/')) {
                return asset($this->foto);
            }
            return asset('storage/' . $this->foto);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&color=047857&background=ecfdf5&size=256&font-size=0.33';
    }
}
