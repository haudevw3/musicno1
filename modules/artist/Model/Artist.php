<?php

namespace Modules\Artist\Model;

use Foundation\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artists';

    protected $fillable = [
        'id',
        '_id',
        'album_ids',
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
        'name' => '',
        'slug' => '',
        'image' => '',
        'description' => '',
    ];
}