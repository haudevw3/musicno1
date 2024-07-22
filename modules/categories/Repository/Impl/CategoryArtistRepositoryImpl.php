<?php

namespace Modules\Categories\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\Categories\Model\CategoryArtist;
use Modules\Categories\Repository\CategoryArtistRepository;

class CategoryArtistRepositoryImpl extends BaseRepositoryImpl implements CategoryArtistRepository
{
    public function getModel()
    {
        return CategoryArtist::class;
    }
}