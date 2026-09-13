<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenerimaBantuan extends Model
{
    use HasFactory;

    protected $table = 'penerima_bantuan';

    protected $fillable = [
        'program_bantuan_id',
        'user_id',
        'nik',
        'nama_penerima',
        'dusun',
        'alamat_detail',
        'jenis_bansos',
        'rincian_yang_diterima',
        'periode',
        'status_penyaluran',
        'tanggal_penyaluran',
        'lokasi_pengambilan',
        'foto_dokumen_daftar',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_penyaluran' => 'date',
        ];
    }

    public function programBantuan(): BelongsTo
    {
        return $this->belongsTo(ProgramBantuan::class, 'program_bantuan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mask NIK for privacy in public transparency tables (e.g. 352901******0001)
     */
    public function getNikMaskedAttribute(): string
    {
        if (strlen($this->nik) >= 16) {
            return substr($this->nik, 0, 6) . '******' . substr($this->nik, -4);
        }
        return substr($this->nik, 0, 3) . '****' . substr($this->nik, -2);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_penyaluran) {
            'terdaftar' => 'Terdaftar sebagai KPM',
            'siap_diambil' => 'Siap Diambil di Balai Desa',
            'sudah_diterima' => 'Sudah Diterima',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst($this->status_penyaluran),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status_penyaluran) {
            'terdaftar' => 'info',
            'siap_diambil' => 'warning',
            'sudah_diterima' => 'success',
            'dibatalkan' => 'danger',
            default => 'gray',
        };
    }
}
