<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizQuestion extends Model
{
    protected $fillable = ['quiz_type', 'question_text', 'options', 'correct_option', 'order', 'time_limit'];
    protected $casts = ['options' => 'array', 'correct_option' => 'integer', 'order' => 'integer', 'time_limit' => 'integer'];

    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class, 'question_id');
    }

    /** Seconds players get to answer. */
    public function timeLimitSeconds(): int
    {
        return (int) ($this->time_limit ?: config('quiz.default_time_limit', 20));
    }
}
