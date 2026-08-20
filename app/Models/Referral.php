<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id', 'referred_id', 'referred_email',
        'referred_phone', 'status', 'points_awarded'
    ];

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'referrer_id');
    }

    public function referred(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'referred_id');
    }
}
