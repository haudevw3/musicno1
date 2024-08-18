<?php

namespace Modules\User\Service;

interface UserService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);
}