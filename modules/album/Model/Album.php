<?php

namespace Modules\Album\Model;

use Foundation\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'album';

    protected $fillable = [
        'id',
        'album_id',
        'name',
        'slug',
        'description',
        'type',
        'image',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'album_id' => '',
        'name' => '',
        'slug' => '',
        'description' => '',
        'type' => 0,
        'image' => '',
    ];
}