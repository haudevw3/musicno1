<?php

namespace Modules\Playlist\Service;

interface PlaylistService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);

    public function deleteAll(array $condition = [], $forever = false);

    public function listPlaylist(array $columns = [], array $conditions = [], array $sorted = ['created_at' => 'desc'], $perPage = 10);

    public function getListSongByPlaylistId($id, array $columns = []);
}