<?php

namespace Modules\Artist\Repository;

use Core\Repository\BaseRepository;
use Modules\Artist\Models\Artist;
use Modules\Artist\Repository\Contracts\ArtistRepository as ArtistRepositoryContract;

class ArtistRepository extends BaseRepository implements ArtistRepositoryContract
{
    /**
     * The model name.
     *
     * @return string
     */
    public function getModel()
    {
        return Artist::class;
    }
}