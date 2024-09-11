<?php

namespace Modules\Album\Controller;

use Foundation\Http\Request;
use Modules\Album\Request\FormCreateAlbum;
use Modules\Album\Request\FormUpdateAlbum;
use Modules\Album\Service\AlbumService;
use Modules\Artist\Service\ArtistService;

class AlbumManageController
{
    protected $albumService;
    protected $artistService;

    public function __construct(AlbumService $albumService, ArtistService $artistService)
    {
        $this->albumService = $albumService;
        $this->artistService = $artistService;
    }

    public function pageManageAlbum(Request $request)
    {
        $artistId = $request->input('artist_id');
        $pagination = $this->albumService->pagination(
            ['id', 'name', 'type', 'created_at', 'updated_at'],
            empty($artistId) ? [] : ['artist_id' => $artistId],
        );
        $albums = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
            'title' => 'Bảng dữ liệu album',
            'albums' => $albums,
            'pagination' => $pagination,
        ];
        return view('album.viewManageAlbum', $data);
    }

    public function createAlbum(FormCreateAlbum $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return response()->json($validated, 500);
        }
        $album = $this->albumService->create($request->all());
        $this->artistService->updateOne($album['artist_id'], ['album_id' => $album['id']]);
        $data = [
            'album_id' => $album['id'],
            'album_type' => $album['type'],
            'artist_id' => $album['artist_id'],
        ];
        return response()->json($data, 201);
    }

    public function pageEditAlbum(Request $request)
    {
        $id = $request->input('id');
        $album = $this->albumService->findOne(['id' => $id]);
        $data = [
            'label' => 2,
            'title' => 'Cập nhật album',
            'album' => $album,
        ];
        return view('album.viewFormManageAlbum', $data);
    }

    public function updateAlbum(FormUpdateAlbum $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return response()->json($validated, 500);
        }
        $data = $request->all();
        $id = $data['id'];
        unset($data['id']);
        $this->albumService->updateOne($id, $data);
        return response()->json($validated);
    }

    public function deleteAlbum(Request $request)
    {
        $id = $request->input('id');
        $album = $this->albumService->deleteOne($id);
        $this->artistService->updateOne($album['artist_id'], ['delete_album_id' => $album['id']]);
        return response()->json();
    }

    public function searchByAlbumName(Request $request)
    {
        $name = $request->input('name');
        $data = $this->albumService->findAll(['id', 'name'], ['like' => ['name' => '%'.$name.'%']]);
        return response()->json($data);
    }
}