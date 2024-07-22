<?php

namespace Modules\Album\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\Album\Model\AlbumSong;
use Modules\Album\Repository\AlbumSongRepository;

class AlbumSongRepositoryImpl extends BaseRepositoryImpl implements AlbumSongRepository
{
    public function getModel()
    {
        return AlbumSong::class;
    }
}