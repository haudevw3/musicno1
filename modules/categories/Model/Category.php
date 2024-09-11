<?php

namespace Modules\Categories\Model;

use Foundation\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'id',
        '_id',
        'parent_id',
        'priority',
        'type',
        'sub_ids',
        'tags',
        'name',
        'slug',
        'image',
        'created_at',
        'updated_at'
    ];

    protected $attributes = [
        '_id' => '',
        'parent_id' => 0,
        'priority' => 0,
        'type' => 0,
        'sub_ids' => '',
        'tags' => '',
        'name' => '',
        'slug' => '',
        'image' => '',
    ];
}