<?php

namespace Modules\User;

use Illuminate\Support\Traits\ForwardsCalls;
use Modules\Tracker\UserStatusTrackingLog;
use Modules\User\Models\User as Model;
use Modules\User\Repository\Contracts\UserRepository;

class User
{
    use ForwardsCalls;

    /**
     * The user model instance.
     *
     * @var \Modules\User\Models\User
     */
    protected $model;

    /**
     * The "user repository" instance.
     *
     * @var \Modules\User\Repository\Contracts\UserRepository
     */
    protected $repository;

    /**
     * The "user status tracking log" instance.
     *
     * @var \Modules\Tracker\UserStatusTrackingLog
     */
    protected $userStatusTrackingLog;

    /**
     * Create a new user instance.
     *
     * @param  \Modules\User\Models\User                          $model
     * @param  \Modules\User\Repository\Contracts\UserRepository  $repository
     * @param  \Modules\Tracker\UserStatusTrackingLog             $userStatusTrackingLog
     * @return void
     */
    public function __construct(Model $model, UserRepository $repository, UserStatusTrackingLog $userStatusTrackingLog)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->userStatusTrackingLog = $userStatusTrackingLog;
    }

    /**
     * Create a new user instance.
     *
     * @param  \Modules\User\Models\User                          $model
     * @param  \Modules\User\Repository\Contracts\UserRepository  $userRepository
     * @return $this
     */
    public static function create(Model $model, UserRepository $userRepository)
    {
        return new static(
            $model, $userRepository, UserStatusTrackingLog::make($model)
        );
    }

    /**
     * Get status badge of the user.
     *
     * @return string
     */
    public function badge()
    {
        return badge(
            $this->userStatusTrackingLog->status() ? 'green' : 'yellow',
            $this->userStatusTrackingLog->getLastStatusLabel(),
        );
    }

    /**
     * Get the value of the model with the given attribute.
     *
     * @param  string  $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->model->$attribute;
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->model, $method, $parameters);
    }
}