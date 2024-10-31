<?php

namespace Modules\User\Repository;

use Core\Repository\BaseRepository;
use Modules\User\Models\User;
use Modules\User\Repository\Contracts\UserRepository as UserRepositoryContract;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
    /**
     * The model name.
     *
     * @return string
     */
    public function getModel()
    {
        return User::class;
    }
}