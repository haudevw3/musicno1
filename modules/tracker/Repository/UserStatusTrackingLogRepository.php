<?php

namespace Modules\Tracker\Repository;

use Core\Repository\BaseRepository;
use Modules\Tracker\Models\UserStatusTrackingLog;
use Modules\Tracker\Repository\Contracts\UserStatusTrackingLogRepository as UserStatusTrackingLogRepositoryContract;

class UserStatusTrackingLogRepository extends BaseRepository implements UserStatusTrackingLogRepositoryContract
{
    /**
     * The model name.
     *
     * @return string
     */
    public function getModel()
    {
        return UserStatusTrackingLog::class;
    }
}