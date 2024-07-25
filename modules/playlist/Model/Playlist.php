<?php

namespace Modules\Playlist\Model;

use Foundation\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'playlist';

    protected $fillable = [
        'id',
        'play_id',
        'name',
        'slug',
        'description',
        'image',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'play_id' => '',
        'name' => '',
        'slug' => '',
        'description' => '',
        'image' => '',
    ];
}