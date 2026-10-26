<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAnswer extends Model
{
    protected $fillable = ['session_id', 'participant_id', 'question_id', 'selected_option', 'is_correct', 'points', 'response_time_ms', 'submitted_at'];
    public $timestamps = false;
    protected $casts = ['is_correct' => 'boolean', 'points' => 'integer', 'response_time_ms' => 'integer', 'submitted_at' => 'datetime'];

    public function session(): BelongsTo
    {
        return $this->belongsTo(QuizSession::class, 'session_id');
    }
    public function participant(): BelongsTo
    {
        return $this->belongsTo(QuizParticipant::class, 'participant_id');
    }
    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }
}
