<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitlistNumber extends Model
{
    protected $table = 'waitlist_numbers';

    protected $fillable = [
        'phone_number',
    ];
}
