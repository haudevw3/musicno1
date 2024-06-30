<?php

namespace Modules\Artist\Service;

interface ArtistService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);

    public function delete(array $condition = [], $forever = false);

    public function listArtist(array $columns = [], array $conditions = [], array $sorted = [], $perPage = 10);
}