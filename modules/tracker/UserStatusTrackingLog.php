<?php

namespace Modules\Tracker;

use Illuminate\Support\Facades\Auth;
use Modules\Tracker\Repository\Contracts\UserStatusTrackingLogRepository;
use Modules\User\Models\User;

class UserStatusTrackingLog
{
    /**
     * The user model instance.
     *
     * @var \Modules\User\Models\User
     */
    protected $user;

    /**
     * The user status.
     *
     * @var bool
     */
    protected $status = false;

    /**
     * The last timestamp of the user.
     *
     * @var int
     */
    protected $lastTimestamp;

    /**
     * The last status label.
     *
     * @var string
     */
    protected $lastStatusLabel;

    /**
     * The last tracking log of the user.
     *
     * @var \Modules\Tracker\Models\UserTrackingLog
     */
    protected $lastLog;

    /**
     * The user tracking logs within today.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $logsWithinToday;

    /**
     * The "user tracking log repository" instance.
     *
     * @var \Modules\Tracker\Repository\Contracts\UserStatusTrackingLogRepository
     */
    protected $repository;

    /**
     * Create a new "user status tracking log" instance.
     *
     * @param  \Modules\User\Models\User                                                   $user
     * @param  \Modules\Tracker\Repository\Contracts\UserStatusTrackingLogRepository|null  $repository
     * @return void
     */
    public function __construct(User $user, UserStatusTrackingLogRepository $repository = null)
    {
        $this->user = $user;
        $this->repository = $repository ?? app(UserStatusTrackingLogRepository::class);
    }

    /**
     * Create a new "user status tracking log" instance.
     *
     * @param  \Modules\User\Models\User                                                   $user
     * @param  \Modules\Tracker\Repository\Contracts\UserStatusTrackingLogRepository|null  $repository
     * @return $this
     */
    public static function make(User $user, UserStatusTrackingLogRepository $repository = null)
    {
        return (new static($user, $repository))
                ->collectTrackingLogWithinToday()
                ->parseCollectedTrackingLogs();
    }

    /**
     * Collect the user tracking log within today.
     *
     * @return $this
     */
    protected function collectTrackingLogWithinToday()
    {
        $this->logsWithinToday = $this->repository->findMany([
            'user_id' => $this->user->id,
            'created_at' => ['$regex' => regex('date_on')]
        ]);

        return $this;
    }

    /**
     * Parse collected tracking logs of the user.
     *
     * @return $this
     */
    protected function parseCollectedTrackingLogs()
    {
        if ($this->logsWithinToday->isNotEmpty()) {
            $this->lastLog = $this->logsWithinToday->last();
            $this->lastTimestamp = time() - $this->lastLog->created_time;
            $this->status = $this->lastTimestamp <= config('tracker.USER_TRACKING_INTERVAL');
        }

        if ($this->status) {
            $this->lastStatusLabel = config('tracker.label.IS_ACTIVE');
        }
        
        elseif ($this->lastTimestamp) {
            $this->lastStatusLabel = preg_replace('/{timestamp}/',
                format_timestamp($this->lastTimestamp, ['hours', 'minutes']), config('tracker.label.ACTIVE_ABOUT')
            );
        }

        else {
            $this->lastStatusLabel = config('tracker.label.IS_NOT_ACTIVE');
        }

        return $this;
    }

    /**
     * Get the user status.
     *
     * @return bool
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * Get the last log of the user.
     *
     * @return \Modules\Tracker\Models\UserTrackingLog|null
     */
    public function getLastLog()
    {
        return $this->lastLog;
    }

    /**
     * Get the last status label of the user.
     *
     * @return string
     */
    public function getLastStatusLabel()
    {
        return $this->lastStatusLabel;
    }

    /**
     * Get the value of the "user tracking log" model with the given attribute.
     *
     * @param  string  $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->lastLog->$attribute;
    }
}