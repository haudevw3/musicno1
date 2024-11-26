<?php

namespace Modules\Track\Repository;

use Core\Repository\BaseRepository;
use Modules\Track\Models\Track;
use Modules\Track\Repository\Contracts\TrackRepository as TrackRepositoryContract;

class TrackRepository extends BaseRepository implements TrackRepositoryContract
{
    /**
     * The model name.
     *
     * @return string
     */
    public function getModel()
    {
        return Track::class;
    }
}