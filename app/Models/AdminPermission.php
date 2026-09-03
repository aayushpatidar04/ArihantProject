<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminPermission extends Model
{
    protected $fillable = ['user_id', 'resource', 'view', 'create', 'edit', 'delete', 'export'];

    protected $casts = [
        'view' => 'boolean',
        'create' => 'boolean',
        'edit' => 'boolean',
        'delete' => 'boolean',
        'export' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function resourceDisplayName(string $resource): string
    {
        return match ($resource) {
            'dashboard' => 'Dashboard',
            'registrations' => 'Registrations',
            'checkins' => 'Check-Ins',
            'event-feedback' => 'Event Feedback',
            'referrals' => 'Referrals',
            'leaderboard' => 'Leaderboard',
            'communications' => 'Communications',
            'influencers' => 'Influencers',
            'stalls' => 'Stalls',
            'admin-management' => 'Admin Management',
            default => ucfirst($resource),
        };
    }
}
