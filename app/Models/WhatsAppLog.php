<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppLog extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_logs';

    protected $fillable = [
        'nomor_tujuan',
        'nama_penerima',
        'tipe_pesan',
        'referensi_id',
        'pesan',
        'status',
        'response_payload',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'response_payload' => 'array',
        'sent_at' => 'datetime',
    ];
}
