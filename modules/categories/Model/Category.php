<?php

namespace Modules\Categories\Model;

use Foundation\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'id',
        'category_id',
        'playlist_ids',
        'name',
        'slug',
        'priority',
        'parent_id',
        'created_at',
        'updated_at'
    ];

    protected $attributes = [
        'category_id' => '',
        'playlist_ids' => '',
        'name' => '',
        'slug' => '',
        'priority' => 0,
        'parent_id' => 0,
    ];
}