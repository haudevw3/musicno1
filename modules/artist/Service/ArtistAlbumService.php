<?php

namespace Modules\Artist\Service;

interface ArtistAlbumService
{
    public function create(array $data);

    public function updateAll($id, array $albumIds);

    public function deleteOne($id);
}