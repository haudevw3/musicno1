<?php

namespace Modules\Playlist\Model;

use Foundation\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'playlists';

    protected $fillable = [
        'id',
        'playlist_id',
        'album_ids',
        'name',
        'slug',
        'description',
        'image',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'playlist_id' => '',
        'album_ids' => '',
        'name' => '',
        'slug' => '',
        'description' => '',
        'image' => '',
    ];
}