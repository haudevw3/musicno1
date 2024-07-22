<?php

namespace Modules\Categories\Model;

use Foundation\Database\Eloquent\Model;

class CategoryPlaylist extends Model
{
    protected $table = 'category_playlist';

    protected $fillable = [
        'id',
        'category_id',
        'playlist_id',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'category_id' => 0,
        'playlist_id' => 0,
    ];
}