<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class QuizSession extends Model
{
    protected $fillable = ['quiz_type', 'pin', 'status', 'current_question_order', 'created_by', 'started_at', 'ended_at', 'question_started_at'];
    protected $casts = ['started_at' => 'datetime', 'ended_at' => 'datetime', 'question_started_at' => 'datetime'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected static function booted()
    {
        static::creating(function (self $s) {
            if (!$s->id)
                $s->id = (string) Str::uuid();
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function participants(): HasMany
    {
        return $this->hasMany(QuizParticipant::class, 'session_id');
    }
    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class, 'session_id');
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['waiting', 'active', 'paused']);
    }
}
