<?php

namespace Modules\FileManager\Repository;

use Core\Repository\BaseRepository;
use Modules\FileManager\Models\File;
use Modules\FileManager\Repository\Contracts\FileRepository as FileRepositoryContract;

class FileRepository extends BaseRepository implements FileRepositoryContract
{
    /**
     * The model name.
     *
     * @return string
     */
    public function getModel()
    {
        return File::class;
    }
}