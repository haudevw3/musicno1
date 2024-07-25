<?php

namespace Modules\Categories\Service;

interface CategoryArtistService
{
    public function create(array $data);

    public function updateOne($categoryId, array $artistIds);

    public function deleteOne($id);
}