<?php

namespace Modules\Categories\Model;

use Foundation\Database\Eloquent\Model;

class CategoryArtist extends Model
{
    protected $table = 'category_artist';

    protected $fillable = [
        'id',
        'category_id',
        'artist_id',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'category_id' => 0,
        'artist_id' => 0,
    ];
}