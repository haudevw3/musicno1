<?php

namespace Modules\Artist\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\Artist\Model\Artist;
use Modules\Artist\Repository\ArtistRepository;

class ArtistRepositoryImpl extends BaseRepositoryImpl implements ArtistRepository
{
    public function getModel()
    {
        return Artist::class;
    }
}