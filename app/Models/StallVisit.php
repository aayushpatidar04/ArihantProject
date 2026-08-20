<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StallVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_registration_id', 'stall_id', 'visited_at',
        'rating', 'feedback', 'quiz_answers', 'quiz_score', 'engagement_points'
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'quiz_answers' => 'array',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'event_registration_id');
    }

    public function stall(): BelongsTo
    {
        return $this->belongsTo(Stall::class);
    }
}
