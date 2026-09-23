<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinbridgeRegistration extends Model
{
    protected $table = "finbridge_registrations";
    protected $fillable = [
        'user_id',
        'registration_number',
        'full_name',
        'email',
        'phone',
        'city',
        'type',
        'interest',
        'has_demat',
        'invest_frequency',
        'start_timeline',
        'products',
        'lead_score',
        'lead_status',
        'status',
        'otp_verified_at',
        'kyc_completed_at',
        'is_existing_client',
    ];

    protected $casts = [
        'has_demat' => 'boolean',
        'products'  => 'array',
    ];

    public function qrCodes(): HasMany
    {
        return $this->hasMany(FinbridgeQrCode::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
