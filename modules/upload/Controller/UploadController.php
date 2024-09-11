<?php

namespace Modules\Upload\Controller;

use Foundation\Http\Request;
use Modules\Upload\Service\UploadService;

class UploadController
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function createFile(Request $request)
    {
        $files = $request->file('files');
        $this->uploadService->create($files);
        return response()->json();
    }

    public function listDetailFile(Request $request)
    {
        $data = $this->uploadService->findAll(['name, link, type', 'updated_at'], [], ['created_at' => 'desc']);
        return response()->json($data);
    }
}