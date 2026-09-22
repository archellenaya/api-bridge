<?php

namespace App\Models\Platform;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'platform_users';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
