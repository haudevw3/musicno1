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
        'sub_id',
        'display_limit',
        'slug',
        'image',
        'created_at',
        'updated_at'
    ];

    protected $attributes = [
        'name' => '',
        'priority' => 0,
        'sub_id' => '',
        'display_limit' => 0,
        'slug' => '',
        'image' => '',
    ];
}