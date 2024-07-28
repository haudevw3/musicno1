<?php

namespace Modules\Album\Service;

interface AlbumSongService
{
    public function create(array $data);

    public function updateAll($id, array $songIds);

    public function deleteOne($id);
}