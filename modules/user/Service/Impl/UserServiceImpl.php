<?php

namespace Modules\User\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\User\Repository\UserRepository;
use Modules\User\Service\UserService;

class UserServiceImpl extends BaseServiceImpl implements UserService
{
    protected $baseRepo;

    public function __construct(UserRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    protected function parseData(array $data)
    {
        return [
            'ip' => request()->ip(),
            'fullname' => trim($data['fullname']),
            'username' => trim($data['username']),
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'email' => trim($data['email']),
            'role' => (int) $data['role'],
            'tel' => isset($data['tel']) ? trim($data['tel']) : null,
            'image' => isset($data['image']) ? trim($data['image']) : null,
        ];
    }

    public function create(array $data)
    {
        return $this->baseRepo->create($this->parseData($data));
    }

    public function updateOne($id, array $data)
    {
        $password = $data['password'];
        $data = $this->parseData($data);
        if ($password == 'musicno1') {
            unset($data['password']);
        }
        return $this->baseRepo->updateOne($id, $data);
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }

    public function delete(array $condition = [], $forever = false)
    {
        $column = array_keys($condition)[0];
        $values = array_values($condition)[0];
        $values = is_array($values) ? $values : [$values];
        foreach ($values as $key => $value) {
            $this->baseRepo->delete([$column => $value]);
        }
        return true;
    }

    public function listUser(array $columns = [], array $conditions = [], array $sorted = [], $perPage = 10)
    {
        return $this->baseRepo->list($columns, $conditions, $sorted, $perPage);
    }
}