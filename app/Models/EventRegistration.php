<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'registration_number', 'full_name', 'email', 'phone', 'city',
        'type', 'is_existing_client', 'status', 'referral_code', 'referred_by',
        'otp_verified_at', 'kyc_completed_at', 'paid_at', 'checked_in_at', 'is_subbroker'
    ];

    protected $casts = [
        'is_existing_client' => 'boolean',
        'otp_verified_at' => 'datetime',
        'kyc_completed_at' => 'datetime',
        'paid_at' => 'datetime',
        'checked_in_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kyc(): HasOne
    {
        return $this->hasOne(KycDetail::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function qrCodes(): HasMany
    {
        return $this->hasMany(QrCode::class);
    }

    public function seat(): HasOne
    {
        return $this->hasOne(Seat::class);
    }

    public function stallVisits(): HasMany
    {
        return $this->hasMany(StallVisit::class);
    }

    public function referralsMade(): HasMany
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function influencerPosts(): HasMany
    {
        return $this->hasMany(InfluencerPost::class);
    }

    public function leadScore(): HasOne
    {
        return $this->hasOne(LeadScore::class);
    }

    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class);
    }
}
