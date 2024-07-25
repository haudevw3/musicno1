<?php

namespace Modules\Playlist\Model;

use Foundation\Database\Eloquent\Model;

class PlaylistAlbum extends Model
{
    protected $table = 'playlist_album';

    protected $fillable = [
        'id',
        'playlist_id',
        'album_id',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'playlist_id' => 0,
        'album_id' => 0,
    ];
}