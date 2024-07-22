<?php

namespace Modules\Album\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\Album\Model\Album;
use Modules\Album\Repository\AlbumRepository;

class AlbumRepositoryImpl extends BaseRepositoryImpl implements AlbumRepository
{
    public function getModel()
    {
        return Album::class;
    }
}