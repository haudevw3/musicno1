<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreateAlbum;
use Modules\Album\Service\AlbumService;
use Modules\Artist\Service\ArtistAlbumService;
use Modules\Artist\Service\ArtistService;
use Foundation\Support\Str;
use Modules\Adm\Request\FormUpdateAlbum;

class AlbumManagerController
{
    protected $albumService;
    protected $artistService;
    protected $artistAlbumService;
    protected $categoriesService;
    protected $categoryAlbumService;

    public function __construct(AlbumService $albumService, ArtistService $artistService, ArtistAlbumService $artistAlbumService)
    {
        $this->albumService = $albumService;
        $this->artistService = $artistService;
        $this->artistAlbumService = $artistAlbumService;
    }

    public function pageManagerAlbum()
    {
        $pagination = $this->albumService->listAlbum();
        $albums = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
            'title' => 'Bảng dữ liệu album',
            'albums' => $albums,
            'pagination' => $pagination,
            'dialog' => config('adm.album.MESSAGE.DIALOG'),
        ];
        return view('adm.viewManagerAlbum', $data);
    }

    public function pageAddAlbum()
    {
        $artists = $this->artistService->findAll(['id', 'name']);
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu tạo album',
            'artists' => $artists,
        ];
        return view('adm.viewCrudAlbum', $data);
    }

    public function createAlbum(FormCreateAlbum $request)
    {
        $validated = $request->validated();
        if (is_array($validated) || ! $request->hasFile('image') || empty($request->input('artist_ids'))) {
            return back()->with('fail', config('adm.album.MESSAGE.CREATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $data['album_id'] = Str::random(22);
        $fileName = $request->file('image')->hash()->move('public/uploads/images');
        $data['image'] = asset("uploads/images/$fileName");
        $artistIds = $data['artist_ids'];
        $album = tap($this->albumService, function ($subject) use ($data) {
            $subject->create($data);
        })->findOne(['album_id' => $data['album_id']]);
        foreach ($artistIds as $artistId) {
            $this->artistAlbumService->create(['artist_id' => $artistId, 'album_id' => $album['id']]);
        }
        return redirect()->route('adm-manager-album', ['page' => 1])
                         ->with('success', config('adm.album.MESSAGE.CREATE_SUCCESS'));
    }

    public function pageEditAlbum(Request $request)
    {
        $id = $request->input('id');
        $album = $this->albumService->findOne(['id' => $id]);
        $artists = $this->artistService->findAll(['id', 'name']);
        $artistAlbum = $this->artistAlbumService->findAll(['artist_id'], ['album_id' => $id]);
        $artistIds = [];
        foreach ($artistAlbum as $value) {
            $artistIds[] = $value['artist_id'];
        }
        $data = [
            'label' => 2,
            'title' => 'Cập nhật nghệ sĩ',
            'album' => $album,
            'artists' => $artists,
            'artistIds' => $artistIds,
        ];
        return view('adm.viewCrudAlbum', $data);
    }

    public function updateAlbum(FormUpdateAlbum $request)
    {
        $validated = $request->validated();
        if (is_array($validated) || empty($request->input('artist_ids'))) {
            return back()->with('fail', config('adm.album.MESSAGE.UPDATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $id = $data['id'];
        unset($data['id']);
        $file = $request->file('image');
        if (is_null($file)) {
            $data['image'] = $data['image_url'];
            unset($data['image_url']);
        } else {
            $fileName = $file->hash()->move('public/uploads/images');
            $data['image'] = asset("uploads/images/$fileName");
        }
        $artistIds = $data['artist_ids'];
        unset($data['artist_ids']);
        $this->albumService->updateOne($id, $data);
        $this->artistAlbumService->updateAll($id, $artistIds);
        return redirect()->route('adm-manager-album', ['page' => 1])
                         ->with('success', config('adm.album.MESSAGE.UPDATE_SUCCESS'));
    }

    public function deleteAlbum(Request $request)
    {
        $id = $request->input('id');
        if ($this->albumService->deleteOne($id)) {
            return back()->with('success', config('adm.album.MESSAGE.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.album.MESSAGE.DELETE_FAIL'));
    }

    public function deleteMultipleAlbum(Request $request)
    {
        $ids = $request->input('ids');
        $this->albumService->deleteAll(['id' => $ids]);
        return redirect()->route('adm-manager-album', ['page' => 1])
                         ->with('success', config('adm.album.MESSAGE.DELETE_SUCCESS'));
    }
}