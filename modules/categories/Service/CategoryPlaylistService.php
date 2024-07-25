<?php

namespace Modules\Categories\Service;

interface CategoryPlaylistService
{
    public function create(array $data);

    public function updateAll($categoryId, array $playlistIds);

    public function deleteOne($id);
}