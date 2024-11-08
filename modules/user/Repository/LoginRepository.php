<?php

namespace Modules\User\Repository;

use Core\Repository\BaseRepository;
use Modules\User\Models\Login;
use Modules\User\Repository\Contracts\LoginRepository as LoginRepositoryContract;

class LoginRepository extends BaseRepository implements LoginRepositoryContract
{
    /**
     * The model name.
     *
     * @return string
     */
    public function getModel()
    {
        return Login::class;
    }
}