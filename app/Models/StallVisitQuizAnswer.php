<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StallVisitQuizAnswer extends Model
{
    protected $fillable = [
        'stall_visit_id',
        'stall_quiz_question_id',
        'stall_quiz_option_id',
        'is_correct',
        'points_earned',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'points_earned' => 'integer',
    ];

    public function visit(): BelongsTo
    {
        return $this->belongsTo(StallVisit::class, 'stall_visit_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(
            StallQuizQuestion::class,
            'stall_quiz_question_id'
        );
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(
            StallQuizOption::class,
            'stall_quiz_option_id'
        );
    }
}