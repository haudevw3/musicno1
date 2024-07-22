<?php

namespace Modules\Album\Model;

use Foundation\Database\Eloquent\Model;

class AlbumSong extends Model
{
    protected $table = 'album_song';

    protected $fillable = [
        'id',
        'album_id',
        'song_id',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'album_id' => 0,
        'song_id' => 0,
    ];
}