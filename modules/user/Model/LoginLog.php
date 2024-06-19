<?php

namespace Modules\User\Model;

use Foundation\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_log';

    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'timed',
        'status',
        'login_time'
    ];

    protected $attributes = [
        'user_id' => 0,
        'ip_address' => '',
        'timed' => 0,
        'status' => '',
    ];
}