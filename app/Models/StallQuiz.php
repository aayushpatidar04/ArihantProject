<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StallQuiz extends Model
{
    protected $fillable = [
        'stall_id',
        'title',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function stall(): BelongsTo
    {
        return $this->belongsTo(Stall::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(StallQuizQuestion::class)
            ->orderBy('sort_order');
    }

    public function activeQuestions(): HasMany
    {
        return $this->hasMany(StallQuizQuestion::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }
}