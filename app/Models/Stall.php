<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Stall extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'location',
        'qr_token',
        'qr_image_path',
        'is_active',
    ];

    protected static function booted(): void
    {
        static::creating(function (Stall $stall) {
            if (empty($stall->qr_token)) {
                $stall->qr_token = static::generateQrToken();
            }
        });
    }

    protected static function generateQrToken(): string
    {
        do {
            $token = Str::random(64);
        } while (static::where('qr_token', $token)->exists());

        return $token;
    }

    public function visits(): HasMany
    {
        return $this->hasMany(StallVisit::class);
    }

    /**
     * Regenerate the public QR token if ever required.
     */
    public function regenerateQrToken(): void
    {
        $this->update([
            'qr_token' => static::generateQrToken(),
        ]);
    }
}