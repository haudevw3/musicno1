<?php

namespace Modules\Playlist\Service;

interface PlaylistAlbumService
{
    public function create(array $data);

    public function updateAll($id, array $albumIds);

    public function deleteOne($id);
}