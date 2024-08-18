<?php

namespace Modules\Playlist\Service;

interface PlaylistService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);

    public function getListAlbumAndSongById(array $condition, array $columns = [], $justNeedSong = false);
}