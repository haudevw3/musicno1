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
        'name',
        'slug',
        'description',
        'type',
        'image',
        'song_ids',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'album_id' => '',
        'artist_id' => 0,
        'name' => '',
        'slug' => '',
        'description' => '',
        'type' => 0,
        'image' => '',
        'song_ids' => '',
    ];
}