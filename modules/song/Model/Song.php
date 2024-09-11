<?php

namespace Modules\Song\Model;

use Foundation\Database\Eloquent\Model;

class Song extends Model
{
    protected $table = 'songs';

    protected $fillable = [
        'id',
        '_id',
        'album_id',
        'artist_id',
        'sub_artist_ids',
        'tags',
        'name',
        'slug',
        'image',
        'audio',
        'duration',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        '_id' => '',
        'album_id' => 0,
        'artist_id' => 0,
        'sub_artist_ids' => '',
        'tags' => '',
        'name' => '',
        'slug' => '',
        'image' => '',
        'audio' => '',
        'duration' => '',
    ];
}