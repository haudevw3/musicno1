<?php

namespace Core\Repository;

interface BaseRepository
{
    public function setModel();

    public function buildQuery(array $columns = [], array $conditions = [], array $options = []);

    public function findOne(array $conditions = [], array $columns = []);

    public function findAll(array $columns = [], array $conditions = [], array $sorted = []);

    public function list(array $columns = [], array $conditions = [], array $sorted = [], $perPage = 10);

    public function create(array $data);

    public function update(array $condition, array $data);

    public function updateOne($id, array $data);

    public function delete(array $condition, $forever = false);

    public function deleteOne($id, $forever = false);
}