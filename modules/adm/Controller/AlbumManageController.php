<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreateSong;
use Modules\Album\Service\AlbumService;
use Modules\Adm\Request\FormUpdateAlbum;
use Modules\Artist\Service\ArtistService;
use Modules\Song\Service\SongService;
use Modules\Song\Object\MP3;
use Foundation\Support\Str;

class AlbumManageController
{
    protected $albumService;
    protected $artistService;
    protected $songService;

    public function __construct(AlbumService $albumService, ArtistService $artistService, SongService $songService)
    {
        $this->albumService = $albumService;
        $this->artistService = $artistService;
        $this->songService = $songService;
    }

    public function pageManageAlbum(Request $request)
    {
        $artistId = $request->input('artist_id');
        $pagination = $this->albumService->listAlbum([], ! empty($artistId) ? ['artist_id' => $artistId] : []);
        $albums = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
            'title' => 'Bảng dữ liệu album',
            'albums' => $albums,
            'pagination' => $pagination,
            'dialog' => config('adm.album.MESSAGES.DIALOG'),
        ];
        return view('adm.viewManageAlbum', $data);
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
            return back()->with('fail', config('adm.album.MESSAGES.UPDATE_FAIL'))
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
        $this->albumService->updateOne($id, $data);
        return redirect()->route('adm-manage-album', ['page' => 1])
                         ->with('success', config('adm.album.MESSAGES.UPDATE_SUCCESS'));
    }

    public function deleteAlbum(Request $request)
    {
        $id = $request->input('id');
        $album = $this->albumService->findOne(['id' => $id]);
        $artist = $this->artistService->findOne(['id' => $album['artist_id']]);
        $albumIds = explode(',', $artist['album_ids']);
        foreach ($albumIds as $key => $value) {
            if ($id == $value) {
                unset($albumIds[$key]);
            }
        }
        $albumIds = empty($albumIds) ? null : implode(',', $albumIds);
        if ($this->albumService->deleteOne($id)) {
            $this->artistService->updateOne($artist['id'], ['album_ids' => $albumIds]);
            return back()->with('success', config('adm.album.MESSAGES.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.album.MESSAGES.DELETE_FAIL'));
    }

    public function pageAddSong(Request $request)
    {
        $id = $request->input('id');
        $album = $this->albumService->findOne(['id' => $id]);
        $artist = $this->artistService->findOne(['id' => $album['artist_id']]);
        $artists = $this->artistService->findAll(['id', 'name']);
        foreach ($artists as $key => $value) {
            if ($value['id'] == $artist['id']) {
                unset($artists[$key]);
                break;
            }
        }
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu tạo bài hát',
            'albumId' => $id,
            'artistId' => $artist['id'],
            'artists' => $artists,
        ];
        return view('adm.viewCrudSong', $data);
    }

    public function createSong(FormCreateSong $request)
    {
        $validated = $request->validated();
        if (is_array($validated) || ! $request->hasFile('image') || ! $request->hasFile('audio')) {
            return back()->with('fail', config('adm.song.MESSAGES.CREATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $data['song_id'] = Str::random(22);
        $fileImage = $request->file('image')->hash()->move('public/uploads/images');
        $data['image'] = asset("uploads/images/$fileImage");
        $fileAudio = $request->file('audio')->hash()->move('public/uploads/audio');
        $data['audio'] = asset("uploads/audio/$fileAudio");
        $duration = 0;
        $mp3 = tap(new MP3(public_path("uploads/audio/$fileAudio")), function ($mp3) use (&$duration) {
            $duration = $mp3->duration();
        });
        $data['duration'] = $mp3->format($duration);
        $song = tap($this->songService, function ($subject) use ($data) {
            $subject->create($data);
        })->findOne(['song_id' => $data['song_id']]);
        $this->albumService->updateOne($data['album_id'], ['song_id' => $song['id']]);
        return redirect()->route('adm-manage-album', ['page' => 1])
                         ->with('success', config('adm.song.MESSAGES.CREATE_SUCCESS'));
    }
}