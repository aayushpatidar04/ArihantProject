<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';
    protected $fillable = [
        'full_name',
        'email',
        'city',
        'phone',
        'experience_rating',
        'session_quality',
        'content_usefulness',
        'networking_rating',
        'most_valuable_session',
        'liked_most',
        'improvements',
        'recommendation',
    ];
}
