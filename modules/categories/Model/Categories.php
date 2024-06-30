<?php

namespace Modules\Categories\Model;

use Foundation\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'id',
        'name',
        'priority',
        'tags',
        'slug',
        'image',
        'created_at',
        'updated_at'
    ];

    protected $attributes = [
        'name' => '',
        'priority' => 0,
        'tags' => '',
        'slug' => '',
        'image' => '',
    ];
}