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
        'subs',
        'slug',
        'image',
        'created_at',
        'updated_at'
    ];

    protected $attributes = [
        'name' => '',
        'priority' => 0,
        'subs' => '',
        'slug' => '',
        'image' => '',
    ];
}