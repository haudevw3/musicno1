<?php

namespace Modules\Tracker\Repository;

use Core\Repository\BaseRepository;
use Modules\Tracker\Models\UserTrackingLog;
use Modules\Tracker\Repository\Contracts\UserTrackingLogRepository as UserTrackingLogRepositoryContract;

class UserTrackingLogRepository extends BaseRepository implements UserTrackingLogRepositoryContract
{
    /**
     * The model name.
     *
     * @return string
     */
    public function getModel()
    {
        return UserTrackingLog::class;
    }
}