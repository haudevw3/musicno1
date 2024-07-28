<?php

namespace Modules\Categories\Service;

interface CategoryPlaylistService
{
    public function create(array $data);

    public function updateAll($id, array $playlistIds);

    public function deleteOne($id);
}