<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizParticipant extends Model
{
    protected $fillable = ['session_id', 'name', 'email', 'mobile', 'joined_at'];
    protected $casts = ['joined_at' => 'datetime'];

    public function session(): BelongsTo
    {
        return $this->belongsTo(QuizSession::class, 'session_id');
    }
    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class, 'session_id');
    }
}
