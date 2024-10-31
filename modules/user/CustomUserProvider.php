<?php

namespace Modules\User;

use Illuminate\Auth\EloquentUserProvider;

class CustomUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     * 
     * {@inheritdoc}
     * 
     * @return mixed
     */
    public function retrieveById($identifier)
    {
        return app(\Modules\User\Repository\Contracts\UserRepository::class)->findOne(['_id' => $identifier]);
    }
}