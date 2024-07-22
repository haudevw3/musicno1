<?php

namespace Modules\Categories\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\Categories\Model\CategoryPlaylist;
use Modules\Categories\Repository\CategoryPlaylistRepository;

class CategoryPlaylistRepositoryImpl extends BaseRepositoryImpl implements CategoryPlaylistRepository
{
    public function getModel()
    {
        return CategoryPlaylist::class;
    }
}