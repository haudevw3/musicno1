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
            'fullname' => ucwords(trim($data['fullname'])),
            'username' => trim($data['username']),
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'email' => trim($data['email']),
            'role' => $data['role'],
            'tel' => ! empty($data['tel']) ? trim($data['tel']) : null,
            'image' => ! empty($data['image']) ? trim($data['image']) : null,
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $user = $this->baseRepo->findOne(['id' => $id]);
        if (array_key_exists('fullname', $data) && $user['fullname'] !== $data['fullname']) {
            $attributes['fullname'] = $data['fullname'];
        }
        if (array_key_exists('username', $data) && $user['username'] !== $data['username']) {
            $attributes['username'] = $data['username'];
        }
        if (array_key_exists('email', $data) && $user['email'] !== $data['email']) {
            $attributes['email'] = $data['email'];
        }
        if (array_key_exists('role', $data) && $user['role'] !== $data['role']) {
            $attributes['role'] = $data['role'];
        }
        if (array_key_exists('tel', $data) && $user['tel'] !== $data['tel']) {
            $attributes['tel'] = $data['tel'];
        }
        if (array_key_exists('image', $data) && $user['image'] !== $data['image']) {
            $attributes['image'] = $data['image'];
        }
        if (array_key_exists('password', $data) && $data['password'] !== 'musicno1') {
            $attributes['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        if (empty($attributes)) {
            return;
        }
        return $this->baseRepo->updateOne($id, $data);
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }

    public function deleteAll(array $condition = [], $forever = false)
    {
        $column = array_keys($condition)[0];
        $values = array_values($condition)[0];
        $values = is_array($values) ? $values : [$values];
        foreach ($values as $value) {
            $this->baseRepo->delete([$column => $value]);
        }
    }

    public function listUser(array $columns = [], array $conditions = [], array $sorted = [], $perPage = 10)
    {
        return $this->baseRepo->list($columns, $conditions, $sorted, $perPage);
    }
}