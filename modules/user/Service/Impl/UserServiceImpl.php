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

    public function create(array $data)
    {
        $attributes = [
            'ip' => request()->ip(),
            'fullname' => isset($data['fullname']) ? trim($data['fullname']) : null,
            'username' => trim($data['username']),
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'email' => isset($data['email']) ? $data['email'] : null,
            'tel' => isset($data['tel']) ? $data['tel'] : null,
            'address' => isset($data['address']) ? $data['address'] : null,
            'role' => (int) $data['role'],
            'image' => isset($data['image']) ? $data['image'] : null
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        if (isset($data['password']) && $data['password'] == 'musicno1') {
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