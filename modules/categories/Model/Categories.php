<?php

namespace Modules\Categories\Model;

use Foundation\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'priority',
        'parent_id',
        'playlist_ids',
        'album_ids',
        'artist_ids',
        'created_at',
        'updated_at'
    ];

    protected $attributes = [
        'name' => '',
        'slug' => '',
        'priority' => 0,
        'parent_id' => 0,
        'playlist_ids' => '',
        'album_ids' => '',
        'artist_ids' => '',
    ];
}