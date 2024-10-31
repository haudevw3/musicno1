<?php

namespace Modules\User\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class RegisterLog extends Model
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
    protected $collection = 'register_logs';

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
    protected $fillable = [];

    /**
     * Define default values for the model's attributes.
     *
     * @var array<string|int, string|null>
     */
    protected $attributes = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];
}
