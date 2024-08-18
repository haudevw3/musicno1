<?php

namespace Modules\Album\Service;

interface AlbumService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);

    public function getListSongById(array $condition, array $columns = [], $justNeedSong = false);
}