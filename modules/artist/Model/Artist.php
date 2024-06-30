<?php

namespace Modules\Artist\Model;

use Foundation\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artist';

    protected $fillable = [
        'id',
        'name',
        'tags',
        'slug',
        'image',
        'biography',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'name' => '',
        'tags' => '',
        'slug' => '',
        'image' => '',
        'biography' => '',
    ];
}