<?php

namespace Modules\Categories\Service;

interface CategoryArtistService
{
    public function create(array $data);

    public function updateOne($artistId, array $data);

    public function deleteOne($id);
}