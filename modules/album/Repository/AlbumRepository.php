<?php

namespace Modules\Album\Repository;

use Core\Repository\BaseRepository;
use Modules\Album\Models\Album;
use Modules\Album\Repository\Contracts\AlbumRepository as AlbumRepositoryContract;

class AlbumRepository extends BaseRepository implements AlbumRepositoryContract
{
    /**
     * The model name.
     *
     * @return string
     */
    public function getModel()
    {
        return Album::class;
    }
}