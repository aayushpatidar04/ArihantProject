<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinbridgeQrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'finbridge_registration_id', 'code', 'image_path',
        'purpose', 'is_used', 'used_at'
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(FinbridgeRegistration::class, 'finbridge_registration_id');
    }
}
