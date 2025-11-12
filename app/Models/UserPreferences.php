<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreferences extends Model
{
    protected $fillable = [
        'push',
        'email',
        'user_id'
    ];

    protected $casts = [
        'push' => 'boolean',
        'email' => 'boolean',
    ];
}
