<?php

namespace Modules\Artist\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\Artist\Model\ArtistAlbum;
use Modules\Artist\Repository\ArtistAlbumRepository;

class ArtistAlbumRepositoryImpl extends BaseRepositoryImpl implements ArtistAlbumRepository
{
    public function getModel()
    {
        return ArtistAlbum::class;
    }
}