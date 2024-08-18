<?php

namespace Modules\Song\Service;

interface SongService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);

    public function getListSongByTags(array $tags, array $columns = []);
}