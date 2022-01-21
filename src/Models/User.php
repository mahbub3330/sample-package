<?php

namespace Gglink\Sample\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'Username',
        'Email',
        'Password',
        'Group',
        'Avatar',
    ];

    public function scopeFilter($query, $search)
    {
        $query->where("Username", "LIKE", "%{$search}%")
            ->orWhere("Email", "LIKE", "%{$search}%");
    }
}
