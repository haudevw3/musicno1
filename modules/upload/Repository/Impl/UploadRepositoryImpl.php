<?php

namespace Modules\Upload\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\Upload\Model\Upload;
use Modules\Upload\Repository\UploadRepository;

class UploadRepositoryImpl extends BaseRepositoryImpl implements UploadRepository
{
    public function getModel()
    {
        return Upload::class;
    }
}