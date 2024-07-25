<?php

namespace Modules\Playlist\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\Playlist\Model\PlaylistAlbum;
use Modules\Playlist\Repository\PlaylistAlbumRepository;

class PlaylistAlbumRepositoryImpl extends BaseRepositoryImpl implements PlaylistAlbumRepository
{
    public function getModel()
    {
        return PlaylistAlbum::class;
    }
}