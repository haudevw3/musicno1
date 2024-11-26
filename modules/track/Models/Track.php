<?php

namespace Modules\Track\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Track extends Model
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
    protected $collection = 'tracks';

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
        'name',
        'slug',
        'type',
        'images',
        'audios',
        'duration',
        'duration_ms',
        'album',
        'artists',
        'created_at',
        'updated_at',
    ];

    /**
     * Define default values for the model's attributes.
     *
     * @var array<string|int, string|int|null>
     */
    protected $attributes = [
        'id' => '',
        'name' => '',
        'slug' => '',
        'type' => '',
        'images' => [],
        'audios' => [],
        'duration' => '',
        'duration_ms' => 0,
        'album' => [],
        'artists' => [],
        'created_at',
        'updated_at',
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
