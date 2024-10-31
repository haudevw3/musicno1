<?php

namespace Modules\User\Repository;

use Core\Repository\BaseRepository;
use Modules\User\Models\Client;
use Modules\User\Repository\Contracts\ClientRepository as ClientRepositoryContract;

class ClientRepository extends BaseRepository implements ClientRepositoryContract
{
    /**
     * The model name.
     *
     * @return string
     */
    public function getModel()
    {
        return Client::class;
    }
}