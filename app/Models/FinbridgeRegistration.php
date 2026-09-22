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
        'status',
        'otp_verified_at',
        'kyc_completed_at',
        'is_existing_client',
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
