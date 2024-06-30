<?php

namespace Modules\Song\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\Song\Model\Song;
use Modules\Song\Repository\SongRepository;

class SongRepositoryImpl extends BaseRepositoryImpl implements SongRepository
{
    public function getModel()
    {
        return Song::class;
    }
}