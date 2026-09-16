<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordResetOtp extends Model
{
    use HasFactory;

    protected $table = 'password_reset_otps';

    protected $fillable = [
        'user_id',
        'nik',
        'telepon',
        'otp',
        'reset_token',
        'attempts',
        'is_used',
        'verified_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'verified_at' => 'datetime',
            'is_used' => 'boolean',
            'attempts' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isExpired(): bool
    {
        return now()->greaterThan($this->expires_at);
    }

    public function isValid(string $inputOtp): bool
    {
        if ($this->is_used) {
            return false;
        }

        if ($this->isExpired()) {
            return false;
        }

        if ($this->attempts >= 5) {
            return false;
        }

        return hash_equals((string) $this->otp, trim($inputOtp));
    }

    public function incrementAttempts(): void
    {
        $this->increment('attempts');
    }

    public function markAsUsed(): void
    {
        $this->update(['is_used' => true]);
    }
}
