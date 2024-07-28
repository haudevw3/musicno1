<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreateArtist;
use Modules\Adm\Request\FormUpdateArtist;
use Modules\Artist\Service\ArtistService;
use Foundation\Support\Str;
use Modules\Album\Service\AlbumService;
use Modules\Artist\Service\ArtistAlbumService;

class ArtistManagerController
{
    protected $artistService;
    protected $artistAlbumService;
    protected $albumService;
    protected $albumSongService;
    protected $songService;

    public function __construct(ArtistService $artistService, ArtistAlbumService $artistAlbumService, AlbumService $albumService)
    {
        $this->artistService = $artistService;
        $this->artistAlbumService = $artistAlbumService;
        $this->albumService = $albumService;
    }

    public function pageManagerArtist()
    {
        $pagination = $this->artistService->listArtist();
        $artists = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
            'title' => 'Bảng dữ liệu nghệ sĩ',
            'artists' => $artists,
            'pagination' => $pagination,
            'dialog' => config('adm.artist.MESSAGE.DIALOG'),
        ];
        return view('adm.viewManagerArtist', $data);
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
            return back()->with('fail', config('adm.artist.MESSAGE.CREATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $data['artist_id'] = Str::random(22);
        $fileName = $request->file('image')->hash()->move('public/uploads/images');
        $data['image'] = asset("uploads/images/$fileName");
        $this->artistService->create($data);
        return redirect()->route('adm-manager-artist', ['page' => 1])
                         ->with('success', config('adm.artist.MESSAGE.CREATE_SUCCESS'));
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
            return back()->with('fail', config('adm.artist.MESSAGE.UPDATE_FAIL'))
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
        $this->artistService->updateOne($id, $data);
        return redirect()->route('adm-manager-artist', ['page' => 1])
                         ->with('success', config('adm.artist.MESSAGE.UPDATE_SUCCESS'));
    }

    public function deleteArtist(Request $request)
    {
        $id = $request->input('id');
        if ($this->artistService->deleteOne($id)) {
            return back()->with('success', config('adm.artist.MESSAGE.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.artist.MESSAGE.DELETE_FAIL'));
    }

    public function deleteMultipleArtist(Request $request)
    {
        $ids = $request->input('ids');
        $this->artistService->deleteAll(['id' => $ids]);
        return redirect()->route('adm-manager-artist', ['page' => 1])
                         ->with('success', config('adm.artist.MESSAGE.DELETE_SUCCESS'));
    }

    public function chooseAlbumForArtist(Request $request)
    {
        $id = $request->input('id');
        $artist = $this->artistService->findOne(['id' => $id], ['id']);
        $albums = $this->albumService->findAll(['id', 'name']);
        $albumIds = [];
        $artistAlbums = $this->artistAlbumService->findAll(['album_id'], ['artist_id' => $id]);
        if (! empty($artistAlbums)) {
            foreach ($artistAlbums as $artistAlbum) {
                $albumIds[] = $artistAlbum['album_id'];
            }
        }
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu chọn album cho nghệ sĩ',
            'artist' => $artist,
            'albums' => $albums,
            'albumIds' => $albumIds,
        ];
        return view('adm.viewChooseAlbumForArtist', $data);
    }

    public function updateAlbumForArtist(Request $request)
    {
        $id = $request->input('id');
        $albumIds = $request->input('album_ids');
        if (empty($albumIds)) {
            return back()->with('fail', config('adm.artist.MESSAGE.CHOOSE_ALBUM_FOR_ARTIST_FAIL'));
        }
        $this->artistAlbumService->updateAll($id, $albumIds);
        return redirect()->route('adm-manager-artist', ['page' => 1])
                         ->with('success', config('adm.artist.MESSAGE.CHOOSE_ALBUM_FOR_ARTIST_SUCCESS'));
    }
}