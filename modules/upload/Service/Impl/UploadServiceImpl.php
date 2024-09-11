<?php

namespace Modules\Upload\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Upload\Repository\UploadRepository;
use Modules\Upload\Service\UploadService;

class UploadServiceImpl extends BaseServiceImpl implements UploadService
{
    protected $baseRepo;

    public function __construct(UploadRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    public function create(array $files)
    {
        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();
            $partsOfOriginalName = explode('.', $originalName);
            unset($partsOfOriginalName[count($partsOfOriginalName) - 1]);
            $name = implode('', $partsOfOriginalName);
            $type = $file->getClientMimeType();
            $aliasName = $file->hash()->move('public/uploads/images');
            $link = asset("uploads/images/$aliasName");
            $attributes = [
                'name' => $name,
                'link' => $link,
                'type' => $type,
            ];
            $this->baseRepo->create($attributes);
        }
    }
}