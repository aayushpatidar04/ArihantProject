<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stall extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'location', 'is_active'];

    public function visits(): HasMany
    {
        return $this->hasMany(StallVisit::class);
    }
}
