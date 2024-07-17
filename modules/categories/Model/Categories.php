<?php

namespace Modules\Categories\Model;

use Foundation\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'id',
        'name',
        'title',
        'slug',
        'image',
        'parent_id',
        'created_at',
        'updated_at'
    ];

    protected $attributes = [
        'name' => '',
        'title' => '',
        'slug' => '',
        'image' => '',
        'parent_id' => 0,
    ];
}