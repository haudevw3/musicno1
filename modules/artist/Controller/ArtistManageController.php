<?php

namespace Modules\Artist\Controller;

use Foundation\Http\Request;
use Modules\Artist\Request\FormCreateArtist;
use Modules\Artist\Request\FormUpdateArtist;
use Modules\Artist\Service\ArtistService;

class ArtistManageController
{
    protected $artistService;

    public function __construct(ArtistService $artistService)
    {
        $this->artistService = $artistService;
    }

    public function pageManageArtist()
    {
        $pagination = $this->artistService->pagination(['id', 'name', 'updated_at']);
        $artists = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'artists' => $artists,
            'pagination' => $pagination,
        ];
        return view('artist.viewManageArtist', $data);
    }

    public function pageAddArtist()
    {
        $data = [
            'title' => 'Tạo nghệ sĩ',
        ];
        return view('artist.viewFormManageArtist', $data);
    }

    public function createArtist(FormCreateArtist $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return response()->json($validated, 500);
        }
        $this->artistService->create($request->all());
        return response()->json($validated, 201);
    }

    public function pageEditArtist(Request $request)
    {
        $id = $request->input('id');
        $artist = $this->artistService->findOne(['id' => $id]);
        $data = [
            'title' => 'Cập nhật nghệ sĩ',
            'artist' => $artist,
        ];
        return view('artist.viewFormManageArtist', $data);
    }

    public function updateArtist(FormUpdateArtist $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return response()->json($validated, 500);
        }
        $data = $request->all();
        $id = $data['id'];
        unset($data['id']);
        $this->artistService->updateOne($id, $data);
        return response()->json($validated);
    }

    public function deleteArtist(Request $request)
    {
        $id = $request->input('id');
        $this->artistService->deleteOne($id);
        return response()->json();
    }

    public function deleteMultipleArtist(Request $request)
    {
        $artistIds = $request->input('artist_ids');
        $artistIds = is_array($artistIds) ? $artistIds : [$artistIds];
        foreach ($artistIds as $id) {
            $this->artistService->deleteOne($id);
        }
        return response()->json();
    }

    public function searchByArtistName(Request $request)
    {
        $name = $request->input('name');
        $data = $this->artistService->findAll(['id', 'name'], ['like' => ['name' => '%'.$name.'%']]);
        return response()->json($data);
    }

    public function pageAddAlbum(Request $request)
    {
        $id = $request->input('id');
        $data = [
            'title' => 'Tạo album',
            'artistId' => $id,
        ];
        return view('album.viewFormManageAlbum', $data);
    }
}