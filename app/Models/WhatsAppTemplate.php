<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppTemplate extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_templates';

    protected $fillable = [
        'kode',
        'nama',
        'kategori',
        'target',
        'konten',
        'variabel_tersedia',
        'is_active',
    ];

    protected $casts = [
        'variabel_tersedia' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Render template dengan mengganti placeholder {variabel}
     */
    public function render(array $data): string
    {
        $message = $this->konten;
        foreach ($data as $key => $value) {
            $message = str_replace('{' . $key . '}', (string) $value, $message);
        }
        return $message;
    }
}
