<?php

namespace Modules\Album\Controller;

use Foundation\Http\Request;
use Modules\Album\Service\AlbumService;

class AlbumController
{
    protected $albumService;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    public function albumDetailPage(Request $request)
    {
        $id = $request->input('id');
        $album = $this->albumService->getListSongById(['album_id' => $id], ['id', 'album_id', 'name', 'image', 'type', 'release_year']);
        return view('album.viewAlbumDetailPage', compact('album'));
    }

    public function getListSongForAlbum(Request $request)
    {
        $id = $request->input('id');
        $data = $this->albumService->getListSongById(['album_id' => $id], ['id', 'album_id'], true);
        return response()->json($data);
    }
}