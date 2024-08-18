<?php

namespace Modules\Album\Model;

use Foundation\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';

    protected $fillable = [
        'id',
        'album_id',
        'artist_id',
        'song_ids',
        'name',
        'slug',
        'image',
        'type',
        'tags',
        'release_year',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'album_id' => '',
        'artist_id' => 0,
        'song_ids' => '',
        'name' => '',
        'slug' => '',
        'image' => '',
        'type' => 0,
        'tags' => '',
        'release_year' => 0,
        'description' => '',
    ];
}