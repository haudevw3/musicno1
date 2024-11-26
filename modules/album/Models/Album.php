<?php

namespace Modules\Album\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Album extends Model
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
    protected $collection = 'albums';

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
        'images',
        'type',
        'album_type',
        'artists',
        'tracks',
        'release_year',
        'total_tracks',
        'label',
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
        'images' => [],
        'type' => '',
        'album_type' => '',
        'artists' => [],
        'tracks' => [],
        'release_year' => 0,
        'total_tracks' => 0,
        'label' => '',
        'created_at' => '',
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

    /**
     * Get a badge following the attribute "album_type".
     *
     * @return string
     */
    public function badge()
    {
        if ($this->album_type == 'single') {
            $badgeKey = 'red';
        } elseif ($this->album_type == 'album') {
            $badgeKey = 'blue';
        } else {
            $badgeKey = 'pink';
        }

        return badge($badgeKey, ucwords($this->album_type));
    }

    /**
     * Get all badges following the attribute "artists".
     *
     * @return string
     */
    public function badges()
    {
        $badges = [];

        foreach ($this->artists as $artist) {
            $badges[] = badge('green', $artist['name']);
        }

        return implode(' ', $badges);
    }
}
