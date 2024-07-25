<?php

namespace Modules\Playlist\Service;

interface PlaylistAlbumService
{
    public function create(array $data);

    public function updateAll($playlistId, array $albumIds);

    public function deleteOne($id);
}