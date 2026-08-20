<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InfluencerPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_registration_id', 'platform', 'post_url',
        'post_type', 'status', 'admin_notes', 'points_awarded', 'approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'event_registration_id');
    }
}
