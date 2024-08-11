<?php

namespace Modules\Song\Model;

use Foundation\Database\Eloquent\Model;

class Song extends Model
{
    protected $table = 'songs';

    protected $fillable = [
        'id',
        'song_id',
        'album_id',
        'artist_id',
        'contributing_artist_ids',
        'name',
        'slug',
        'image',
        'duration',
        'audio',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'song_id' => '',
        'album_id' => 0,
        'artist_id' => 0,
        'contributing_artist_ids' => '',
        'name' => '',
        'slug' => '',
        'image' => '',
        'duration' => '',
        'audio' => '',
    ];
}