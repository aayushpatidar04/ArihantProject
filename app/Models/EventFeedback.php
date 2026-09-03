<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventFeedback extends Model
{
    protected $table = 'event_feedbacks';
    protected $fillable = [
        'event_registration_id',
        'experience_rating',
        'session_quality',
        'content_usefulness',
        'networking_rating',
        'most_valuable_session',
        'liked_most',
        'improvements',
        'recommendation',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'event_registration_id');
    }
}