<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KnowledgeDocument extends Model
{
    use HasFactory;

    protected $table = 'knowledge_document';

    protected $fillable = [
        'user_id',
        'nama_file',
        'path',
        'kategori',
        'jumlah_chunks',
        'is_indexed',
        'status_indexing',
        'dify_document_id',
    ];

    protected function casts(): array
    {
        return [
            'is_indexed' => 'boolean',
            'jumlah_chunks' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
