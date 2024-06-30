<?php

namespace Modules\Song\Model;

use Foundation\Database\Eloquent\Model;

class Song extends Model
{
    protected $table = 'song';

    protected $fillable = [
        'id',
        'name',
        'artist_id',
        'album_id',
        'tags',
        'duration',
        'composer',
        'image',
        'audio',
        'slug',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'name' => '',
        'artist_id' => 0,
        'album_id' => 0,
        'tags' => '',
        'duration' => '',
        'composer' => '',
        'image' => '',
        'audio' => '',
        'slug' => '',
    ];
}