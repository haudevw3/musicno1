<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreateArtist;
use Modules\Adm\Request\FormUpdateArtist;
use Modules\Artist\Service\ArtistService;
use Foundation\Support\Str;
use Modules\Adm\Request\FormCreateAlbum;
use Modules\Album\Service\AlbumService;

class ArtistManageController
{
    protected $artistService;
    protected $albumService;

    public function __construct(ArtistService $artistService, AlbumService $albumService)
    {
        $this->artistService = $artistService;
        $this->albumService = $albumService;
    }

    public function pageManageArtist()
    {
        $pagination = $this->artistService->listArtist();
        $artists = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
            'title' => 'Bảng dữ liệu nghệ sĩ',
            'artists' => $artists,
            'pagination' => $pagination,
            'dialog' => config('adm.artist.MESSAGES.DIALOG'),
        ];
        return view('adm.viewManageArtist', $data);
    }

    public function pageAddArtist()
    {
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu tạo nghệ sĩ',
        ];
        return view('adm.viewCrudArtist', $data);
    }

    public function createArtist(FormCreateArtist $request)
    {
        $validated = $request->validated();
        if (is_array($validated) || ! $request->hasFile('image')) {
            return back()->with('fail', config('adm.artist.MESSAGES.CREATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $data['artist_id'] = Str::random(22);
        $fileName = $request->file('image')->hash()->move('public/uploads/images');
        $data['image'] = asset("uploads/images/$fileName");
        $this->artistService->create($data);
        return redirect()->route('adm-manage-artist', ['page' => 1])
                         ->with('success', config('adm.artist.MESSAGES.CREATE_SUCCESS'));
    }

    public function pageEditArtist(Request $request)
    {
        $id = $request->input('id');
        $artist = $this->artistService->findOne(['id' => $id]);
        $data = [
            'label' => 2,
            'title' => 'Cập nhật nghệ sĩ',
            'artist' => $artist,
        ];
        return view('adm.viewCrudArtist', $data);
    }

    public function updateArtist(FormUpdateArtist $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return back()->with('fail', config('adm.artist.MESSAGES.UPDATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $id = $data['id'];
        unset($data['id']);
        if ($request->hasFile('image')) {
            $fileName = $request->file('image')->hash()->move('public/uploads/images');
            $data['image'] = asset("uploads/images/$fileName");
        } else {
            $data['image'] = $data['image_url'];
        }
        unset($data['image_url']);
        $this->artistService->updateOne($id, $data);
        return redirect()->route('adm-manage-artist', ['page' => 1])
                         ->with('success', config('adm.artist.MESSAGES.UPDATE_SUCCESS'));
    }

    public function deleteArtist(Request $request)
    {
        $id = $request->input('id');
        if ($this->artistService->deleteOne($id)) {
            return back()->with('success', config('adm.artist.MESSAGES.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.artist.MESSAGES.DELETE_FAIL'));
    }

    public function deleteMultipleArtist(Request $request)
    {
        $ids = $request->input('artist_ids');
        $this->artistService->deleteAll(['id' => $ids]);
        return redirect()->route('adm-manage-artist', ['page' => 1])
                         ->with('success', config('adm.artist.MESSAGES.DELETE_SUCCESS'));
    }

    public function pageAddAlbum(Request $request)
    {
        $id = $request->input('id');
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu tạo album',
            'artistId' => $id,
        ];
        return view('adm.viewCrudAlbum', $data);
    }

    public function createAlbum(FormCreateAlbum $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return back()->with('fail', config('adm.album.MESSAGES.CREATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $data['album_id'] = Str::random(22);
        $data['image'] = null;
        if ($request->hasFile('image')) {
            $fileName = $request->file('image')->hash()->move('public/uploads/images');
            $data['image'] = asset("uploads/images/$fileName");
        }
        $album = tap($this->albumService, function ($subject) use ($data) {
            $subject->create($data);
        })->findOne(['album_id' => $data['album_id']]);
        $this->artistService->updateOne($data['artist_id'], ['album_id' => $album['id']]);
        return redirect()->route('adm-manage-artist', ['page' => 1])
                         ->with('success', config('adm.album.MESSAGES.CREATE_SUCCESS'));
    }
}