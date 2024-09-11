<?php

namespace Modules\Upload\Model;

use Foundation\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'uploads';

    protected $fillable = [
        'id',
        'name',
        'link',
        'type',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'name' => '',
        'link' => '',
        'type' => '',
    ];
}