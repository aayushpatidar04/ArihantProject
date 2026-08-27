<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StallFeedbackOption extends Model
{
    protected $fillable = [
        'stall_feedback_question_id',
        'option_text',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(
            StallFeedbackQuestion::class,
            'stall_feedback_question_id'
        );
    }
}