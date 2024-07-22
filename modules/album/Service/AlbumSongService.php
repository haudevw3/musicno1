<?php

namespace Modules\Album\Service;

interface AlbumSongService
{
    public function create(array $data);

    public function updateAll($songId, array $albumIds);

    public function deleteOne($id);
}