<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenPersyaratan extends Model
{
    use HasFactory;

    protected $table = 'dokumen_persyaratan';

    protected $fillable = [
        'permohonan_id',
        'nama_file',
        'path',
        'tipe_dokumen',
        'ukuran_file',
    ];

    public function permohonanSurat(): BelongsTo
    {
        return $this->belongsTo(PermohonanSurat::class, 'permohonan_id');
    }
}
