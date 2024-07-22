<?php

namespace Modules\Artist\Model;

use Foundation\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artist';

    protected $fillable = [
        'id',
        'artist_id',
        'name',
        'slug',
        'image',
        'description',
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