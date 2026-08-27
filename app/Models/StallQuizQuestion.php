<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StallQuizQuestion extends Model
{
    protected $fillable = [
        'stall_quiz_id',
        'question',
        'points',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'points' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(StallQuiz::class, 'stall_quiz_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(StallQuizOption::class)
            ->orderBy('sort_order');
    }

    public function correctOption(): HasMany
    {
        return $this->hasMany(StallQuizOption::class)
            ->where('is_correct', true);
    }
}