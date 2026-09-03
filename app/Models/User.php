<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function eventRegistration(): HasOne
    {
        return $this->hasOne(EventRegistration::class);
    }

    public function influencerPosts(): HasMany
    {
        return $this->hasMany(InfluencerPost::class);
    }

    public function isInfluencer(): bool
    {
        return $this->role === 'influencer';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}