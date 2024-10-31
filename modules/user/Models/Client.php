<?php

namespace Modules\User\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Client extends Model
{
    /**
     * Assign different a connection if any.
     *
     * @var string
     */
    protected $connection = 'musicno1';

    /**
     * The collection name in Mongo DB.
     *
     * @var string
     */
    protected $collection = 'clients';

    /**
     * The attribute will disabled.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Assign fields to save in the database.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        '_id',
        'id',
        'ip',
        'user_id',
        'session_id',
        'token',
        'refresh_token',
        'remember_token',
        'status',
        'created_at',
        'updated_at',
        'created_time',
    ];

    /**
     * Define default values for the model's attributes.
     *
     * @var array<string|int, string|null>
     */
    protected $attributes = [
        'id' => '',
        'ip' => '',
        'user_id' => '',
        'session_id' => '',
        'token' => '',
        'refresh_token' => '',
        'remember_token' => '',
        'status' => 1,
        'created_at' => '',
        'updated_at' => '',
        'created_time' => 0,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'session_id',
        'remember_token',
        'access_token',
        'refresh_token',
    ];
}
