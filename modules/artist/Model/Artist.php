<?php

namespace Modules\Artist\Model;

use Foundation\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artists';

    protected $fillable = [
        'id',
        'artist_id',
        'name',
        'slug',
        'image',
        'description',
        'album_ids',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'artist_id' => '',
        'name' => '',
        'slug' => '',
        'image' => '',
        'description' => '',
    ];
}