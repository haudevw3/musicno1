<?php

namespace Modules\Artist\Service;

interface ArtistAlbumService
{
    public function create(array $data);

    public function updateAll($albumId, array $artistIds);

    public function deleteOne($id);
}