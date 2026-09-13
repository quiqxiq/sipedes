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

    /**
     * Mengambil daftar berkas persyaratan dalam format terstruktur dan ternormalisasi.
     */
    public function getPersyaratanListAttribute(): array
    {
        $raw = $this->syarat ?? [];
        if (!is_array($raw)) {
            return [];
        }

        $normalized = [];
        foreach ($raw as $item) {
            if (is_string($item)) {
                $trimmed = trim($item);
                if ($trimmed !== '') {
                    $normalized[] = [
                        'nama' => $trimmed,
                        'wajib' => true,
                        'keterangan' => null,
                    ];
                }
            } elseif (is_array($item) && !empty($item['nama'])) {
                $normalized[] = [
                    'nama' => trim($item['nama']),
                    'wajib' => isset($item['wajib']) ? (bool) $item['wajib'] : true,
                    'keterangan' => $item['keterangan'] ?? null,
                ];
            }
        }

        return $normalized;
    }
}
