<?php

namespace Modules\Album\Service;

interface AlbumService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);

    public function deleteAll(array $condition = [], $forever = false);

    public function listAlbum(array $columns = [], array $conditions = [], array $sorted = ['created_at' => 'desc'], $perPage = 10);

    public function getListSongByAlbumId($id, array $columns = []);
}