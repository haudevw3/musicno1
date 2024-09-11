<?php

namespace Modules\Playlist\Model;

use Foundation\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'playlists';

    protected $fillable = [
        'id',
        '_id',
        'album_ids',
        'priority',
        'name',
        'slug',
        'image',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        '_id' => '',
        'album_ids' => '',
        'priority' => 0,
        'name' => '',
        'slug' => '',
        'image' => '',
        'description' => '',
    ];
}