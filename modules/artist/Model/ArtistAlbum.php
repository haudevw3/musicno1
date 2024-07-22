<?php

namespace Modules\Artist\Model;

use Foundation\Database\Eloquent\Model;

class ArtistAlbum extends Model
{
    protected $table = 'artist_album';

    protected $fillable = [
        'id',
        'artist_id',
        'album_id',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'artist_id' => 0,
        'album_id' => 0,
    ];
}