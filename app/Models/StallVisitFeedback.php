<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StallVisitFeedback extends Model
{
    protected $fillable = [
        'stall_visit_id',
        'stall_feedback_question_id',
        'answer',
    ];

    public function visit(): BelongsTo
    {
        return $this->belongsTo(StallVisit::class, 'stall_visit_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(
            StallFeedbackQuestion::class,
            'stall_feedback_question_id'
        );
    }
}