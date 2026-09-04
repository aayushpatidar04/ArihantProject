<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizQuestion extends Model
{
    protected $fillable = ['quiz_type', 'question_text', 'options', 'correct_option', 'order'];
    protected $casts = ['options' => 'array', 'correct_option' => 'integer', 'order' => 'integer'];

    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
