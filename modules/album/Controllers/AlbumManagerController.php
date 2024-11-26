<?php

namespace Modules\Album\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Album\Request\FormCreateAlbum;
use Modules\Album\Service\Contracts\AlbumService;

class AlbumManagerController extends Controller
{
    protected $albumService;

    /**
     * @param  \Modules\Album\Service\Contracts\AlbumService  $albumService
     * @return void
     */
    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    public function pageAddAlbum(Request $request)
    {
        return view('album::viewFormAlbum');
    }

    public function createAlbumApi(FormCreateAlbum $request)
    {
        $response = $this->albumService->create($request->all());

        return $response->withJson();
    }

    public function deleteAlbumApi(Request $request)
    {
        $response = $this->albumService->deleteOne(
            $request->input('id')
        );

        return $response->withJson();
    }
}
