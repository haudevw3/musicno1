<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreateAlbum;
use Modules\Album\Service\AlbumService;
use Foundation\Support\Str;
use Modules\Adm\Request\FormUpdateAlbum;
use Modules\Album\Service\AlbumSongService;
use Modules\Song\Service\SongService;

class AlbumManagerController
{
    protected $albumService;
    protected $albumSongService;
    protected $songService;

    public function __construct(AlbumService $albumService, AlbumSongService $albumSongService, SongService $songService)
    {
        $this->albumService = $albumService;
        $this->albumSongService = $albumSongService;
        $this->songService = $songService;
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
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu tạo album',
        ];
        return view('adm.viewCrudAlbum', $data);
    }

    public function createAlbum(FormCreateAlbum $request)
    {
        $validated = $request->validated();
        if (is_array($validated) || ! $request->hasFile('image')) {
            return back()->with('fail', config('adm.album.MESSAGE.CREATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $data['album_id'] = Str::random(22);
        $fileName = $request->file('image')->hash()->move('public/uploads/images');
        $data['image'] = asset("uploads/images/$fileName");
        $this->albumService->create($data);
        return redirect()->route('adm-manager-album', ['page' => 1])
                         ->with('success', config('adm.album.MESSAGE.CREATE_SUCCESS'));
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
        return view('adm.viewCrudAlbum', $data);
    }

    public function updateAlbum(FormUpdateAlbum $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
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
        $this->albumService->updateOne($id, $data);
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

    public function chooseSongForAlbum(Request $request)
    {
        $id = $request->input('id');
        $album = $this->albumService->findOne(['id' => $id], ['id', 'type']);
        $songs = $this->songService->findAll(['id', 'name']);
        $songIds = [];
        $albumSongs = $this->albumSongService->findAll(['song_id'], ['album_id' => $id]);
        if (! empty($albumSongs)) {
            foreach ($albumSongs as $albumSong) {
                $songIds[] = $albumSong['song_id'];
            }
        }
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu chọn bài hát cho album',
            'album' => $album,
            'songs' => $songs,
            'songIds' => $songIds,
        ];
        return view('adm.viewChooseSongForAlbum', $data);
    }

    public function updateSongForAlbum(Request $request)
    {
        $id = $request->input('id');
        $album = $this->albumService->findOne(['id' => $id], ['id', 'type']);
        $songIds = $request->input('song_ids');
        if (empty($songIds) && $album['type'] == 1) {
            return back()->with('fail', config('adm.album.MESSAGE.CHOOSE_SONG_FOR_ALBUM_FAIL'));
        }
        $this->albumSongService->updateAll($id, empty($songIds) ? [] : $songIds);
        return redirect()->route('adm-manager-album', ['page' => 1])
                         ->with('success', config('adm.album.MESSAGE.CHOOSE_SONG_FOR_ALBUM_SUCCESS'));
    }
}