<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InfluencerPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'platform', 'post_url',
        'post_type', 'status', 'admin_notes', 'points_awarded', 'approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function influencer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
