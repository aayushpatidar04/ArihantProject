<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_super_admin',
        'can_view_pii',
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
            'is_super_admin' => 'boolean',
            'can_view_pii' => 'boolean',
        ];
    }

    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function influencerPosts(): HasMany
    {
        return $this->hasMany(InfluencerPost::class);
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(AdminPermission::class);
    }

    public function isInfluencer(): bool
    {
        return $this->role === 'influencer';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin;
    }

    /**
     * Returns true if the user can see unmasked PII (email, phone, name).
     * Super admins always have this. Regular admins need the flag toggled on.
     */
    public function canViewPii(): bool
    {
        return $this->isSuperAdmin() || $this->can_view_pii;
    }

    public function can($abilities, $arguments = [])
    {
        if (!is_string($abilities) || !is_string($arguments)) {
            return parent::can($abilities, $arguments);
        }

        $resource = $abilities;
        $action = $arguments;

        if ($this->isSuperAdmin()) {
            return true;
        }

        $perm = $this->permissions()->where('resource', $resource)->first();
        if (!$perm) {
            return false;
        }

        return (bool) $perm->{$action};
    }

    // PII masking helpers
    public static function maskEmail(string $email): string
    {
        [$local, $domain] = explode('@', $email, 2);
        $maskedLocal = str_repeat('*', min(4, strlen($local)));
        return $maskedLocal . str_repeat('*', max(0, strlen($local) - 4)) . '@' . $domain;
    }

    public static function maskPhone(string $phone): string
    {
        $len = strlen($phone);
        if ($len <= 4)
            return str_repeat('*', $len);
        return str_repeat('*', $len - 4) . substr($phone, -4);
    }

    public static function maskName(string $name): string
    {
        $parts = explode(' ', trim($name));
        foreach ($parts as &$part) {
            if (strlen($part) > 2) {
                $part = $part[0] . str_repeat('*', strlen($part) - 1);
            }
        }
        return implode(' ', $parts);
    }
}
