<?php

namespace Modules\Song\Model;

use Foundation\Database\Eloquent\Model;

class Song extends Model
{
    protected $table = 'song';

    protected $fillable = [
        'id',
        'song_id',
        'name',
        'slug',
        'image',
        'duration',
        'audio',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'song_id' => '',
        'name' => '',
        'slug' => '',
        'image' => '',
        'duration' => '',
        'audio' => '',
    ];
}