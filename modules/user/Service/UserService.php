<?php

namespace Modules\User\Service;

interface UserService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);

    public function deleteAll(array $condition = [], $forever = false);

    public function listUser(array $columns = [], array $conditions = [], array $sorted = ['created_at' => 'desc'], $perPage = 10);
}