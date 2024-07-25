<?php

namespace Modules\Playlist\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\Playlist\Model\Playlist;
use Modules\Playlist\Repository\PlaylistRepository;

class PlaylistRepositoryImpl extends BaseRepositoryImpl implements PlaylistRepository
{
    public function getModel()
    {
        return Playlist::class;
    }
}