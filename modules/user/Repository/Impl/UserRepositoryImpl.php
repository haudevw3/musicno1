<?php

namespace Modules\User\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\User\Model\User;
use Modules\User\Repository\UserRepository;

class UserRepositoryImpl extends BaseRepositoryImpl implements UserRepository
{
    public function getModel()
    {
        return User::class;
    }
}