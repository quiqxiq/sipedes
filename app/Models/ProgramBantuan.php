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
        'foto_pengumuman',
        'penanggung_jawab',
    ];

    protected function casts(): array
    {
        return [
            'syarat_dokumen' => 'array',
            'foto_pengumuman' => 'array',
            'kuota_penerima' => 'integer',
            'tahun_anggaran' => 'integer',
        ];
    }

    public function penerimaBantuans()
    {
        return $this->hasMany(PenerimaBantuan::class, 'program_bantuan_id');
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'pkh' => 'Program Keluarga Harapan (PKH)',
            'bansos_lansia' => 'Bansos Lansia & Disabilitas',
            'blt_dana_desa', 'bansos_tunai' => 'BLT Dana Desa (BLT-DD)',
            'beras_cbp' => 'Bantuan Beras CBP (10 Kg)',
            'pangan_sembako', 'bpnt_sembako' => 'BPNT / Program Sembako',
            'pertanian_bibit', 'pertanian_pupuk' => 'Bantuan Pertanian & Pupuk Subsidi',
            'kesehatan_stunting' => 'PMT Gizi & Stunting Balita',
            default => 'Bantuan Sosial',
        };
    }
}
