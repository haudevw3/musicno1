<?php

namespace Modules\Artist\Service;

interface ArtistService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);
}