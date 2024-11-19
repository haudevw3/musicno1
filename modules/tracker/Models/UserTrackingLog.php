<?php

namespace Modules\Tracker\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class UserTrackingLog extends Model
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
    protected $collection = 'user_tracking_logs';

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
        'ip',
        'user_id',
        'status',
        'created_time',
        'created_at',
        'updated_at',
    ];

    /**
     * Define default values for the model's attributes.
     *
     * @var array<string|int, string|int|null>
     */
    protected $attributes = [
        'ip' => '',
        'user_id' => '',
        'status' => 0,
        'created_at' => '',
        'created_time' => '',
        'updated_at' => '',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];
}
