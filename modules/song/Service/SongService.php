<?php

namespace Modules\Song\Service;

interface SongService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);

    public function delete(array $condition = [], $forever = false);

    public function listSong(array $columns = [], array $conditions = [], array $sorted = [], $perPage = 10);
}