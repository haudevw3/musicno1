<?php

namespace Modules\FileManager\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\FileManager\Service\Contracts\FileService;

class FileController extends Controller
{
    protected $fileService;

    /**
     * @param \Modules\FileManager\Service\Contracts\FileService  $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function getFileListApi(Request $request)
    {
        $data = $this->fileService->findMany([], ['name', 'type', 'url', 'updated_at']);

        return response()->json($data, 200);
    }

    public function uploadFileApi(Request $request)
    {
        $this->fileService->upload($request->file('files'));

        return response()->json(
            ['success' => config('filemanager.label.CREATE_SUCCESS')], 201
        );
    }
}
