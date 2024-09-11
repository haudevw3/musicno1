<?php

namespace Modules\Album\Model;

use Foundation\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';

    protected $fillable = [
        'id',
        '_id',
        'artist_id',
        'song_ids',
        'name',
        'slug',
        'image',
        'type',
        'release_year',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        '_id' => '',
        'artist_id' => 0,
        'song_ids' => '',
        'name' => '',
        'slug' => '',
        'image' => '',
        'type' => 0,
        'release_year' => 0,
        'description' => '',
    ];
}