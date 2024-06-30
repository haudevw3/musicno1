<?php

namespace Modules\User\Model;

use Foundation\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'id',
        'ip',
        'fullname',
        'username',
        'password',
        'email',
        'tel',
        'role',
        'image',
        'session_id',
        'remember_token',
        // 'access_token',
        // 'refresh_token',
        'forgot_token',
        'active_token',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'ip' => '',
        'fullname' => '',
        'username' => '',
        'password' => '',
        'email' => '',
        'tel' => '',
        'role' => 0,
        'image' => '',
        'session_id' => '',
        'remember_token' => '',
        // 'access_token' => '',
        // 'refresh_token' => '',
        'forgot_token' => '',
        'active_token' => '',
    ];

    protected $hidden = [
        'password',
        // 'access_token',
        // 'refresh_token',
    ];
}