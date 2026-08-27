<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StallFeedbackQuestion extends Model
{
    protected $fillable = [
        'stall_id',
        'question',
        'type',
        'is_required',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function stall(): BelongsTo
    {
        return $this->belongsTo(Stall::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(StallFeedbackOption::class)
            ->orderBy('sort_order');
    }
}