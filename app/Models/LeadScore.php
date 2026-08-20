<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_registration_id', 'registration_score', 'kyc_score',
        'quiz_score', 'stall_visit_score', 'referral_score',
        'social_score', 'total_score', 'synced_to_crm', 'synced_at'
    ];

    protected $casts = [
        'synced_to_crm' => 'boolean',
        'synced_at' => 'datetime',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'event_registration_id');
    }
}
