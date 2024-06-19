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
        'address',
        'roles',
        'session_id',
        'remember_token',
        'image',
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
        'address' => '',
        'roles' => '',
        'session_id' => '',
        'remember_token' => '',
        'image' => '',
        'forgot_token' => '',
        'active_token' => '',
    ];

    protected $hidden = [
        'password',
    ];
}