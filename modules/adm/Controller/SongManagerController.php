<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreateSong;
use Modules\Adm\Request\FormUpdateSong;
use Modules\Album\Service\AlbumService;
use Modules\Artist\Service\ArtistAlbumService;
use Modules\Artist\Service\ArtistService;
use Modules\Song\Object\MP3;
use Modules\Song\Service\SongService;
use Foundation\Support\Str;
use Modules\Album\Service\AlbumSongService;

class SongManagerController
{
    protected $songService;
    protected $artistService;
    protected $albumService;
    protected $albumSongService;
    protected $artistAlbumService;

    public function __construct(SongService $songService, ArtistService $artistService, AlbumService $albumService, AlbumSongService $albumSongService,
                                ArtistAlbumService $artistAlbumService)
    {
        $this->songService = $songService;
        $this->artistService = $artistService;
        $this->albumService = $albumService;
        $this->albumSongService = $albumSongService;
        $this->artistAlbumService = $artistAlbumService;
    }

    public function pageManagerSong()
    {
        $pagination = $this->songService->listSong();
        $songs = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
            'title' => 'Bảng dữ liệu bài hát',
            'songs' => $songs,
            'pagination' => $pagination,
            'dialog' => config('adm.song.MESSAGE.DIALOG'),
        ];
        return view('adm.viewManagerSong', $data);
    }

    public function pageAddSong()
    {
        $albums = $this->albumService->findAll(['id', 'name']);
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu tạo bài hát',
            'albums' => $albums,
        ];
        return view('adm.viewCrudSong', $data);
    }

    public function createSong(FormCreateSong $request)
    {
        $validated = $request->validated();
        if (is_array($validated) || ! $request->hasFile('image') ||
            ! $request->hasFile('audio') || empty($request->input('album_ids'))) {
            return back()->with('fail', config('adm.song.MESSAGE.CREATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $data['song_id'] = Str::random(22);
        $albumIds = $data['album_ids'];
        unset($data['album_ids']);
        foreach ($albumIds as $albumId) {
            $artistId = $this->artistAlbumService->findOne(['album_id' => $albumId])['artist_id'];
            $data['artist_names'][] = $this->artistService->findOne(['id' => $artistId])['name'];
        }
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
        foreach ($albumIds as $albumId) {
            $this->albumSongService->create(['album_id' => $albumId, 'song_id' => $song['id']]);
        }
        return redirect()->route('adm-manager-song', ['page' => 1])
                         ->with('success', config('adm.song.MESSAGE.CREATE_SUCCESS'));
    }

    public function pageEditSong(Request $request)
    {
        $id = $request->input('id');
        $song = $this->songService->findOne(['id' => $id]);
        $albums = $this->albumService->findAll(['id', 'name']);
        $albumSongs = $this->albumSongService->findAll(['album_id'], ['song_id' => $id]);
        $albumIds = [];
        foreach ($albumSongs as $value) {
            $albumIds[] = $value['album_id'];
        }
        $data = [
            'label' => 2,
            'title' => 'Cập nhật bài hát',
            'song' => $song,
            'albums' => $albums,
            'albumIds' => $albumIds,
        ];
        return view('adm.viewCrudSong', $data);
    }

    public function updateSong(FormUpdateSong $request)
    {
        $validated = $request->validated();
        if (is_array($validated) || empty($request->input('album_ids'))) {
            return back()->with('fail', config('adm.song.MESSAGE.UPDATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $id = $data['id'];
        unset($data['id']);
        $fileImage = $request->file('image');
        if (is_null($fileImage)) {
            $data['image'] = $data['image_url'];
            unset($data['image_url']);
        } else {
            $fileName = $fileImage->hash()->move('public/uploads/images');
            $data['image'] = asset("uploads/images/$fileName");
        }
        $fileAudio = $request->file('audio');
        if (is_null($fileAudio)) {
            $data['audio'] = $data['audio_url'];
            unset($data['audio_url']);
        } else {
            $fileName = $fileAudio->hash()->move('public/uploads/audio');
            $data['audio'] = asset("uploads/audio/$fileName");
            $duration = 0;
            $mp3 = tap(new MP3(public_path("uploads/audio/$fileName")), function ($mp3) use (&$duration) {
                $duration = $mp3->duration();
            });
            $data['duration'] = $mp3->format($duration);
        }
        $albumIds = $data['album_ids'];
        unset($data['album_ids']);
        foreach ($albumIds as $albumId) {
            $artistId = $this->artistAlbumService->findOne(['album_id' => $albumId])['artist_id'];
            $data['artist_names'][] = $this->artistService->findOne(['id' => $artistId])['name'];
        }
        $this->songService->updateOne($id, $data);
        $this->albumSongService->updateAll($id, $albumIds);
        return redirect()->route('adm-manager-song', ['page' => 1])
                         ->with('success', config('adm.song.MESSAGE.UPDATE_SUCCESS'));
    }

    public function deleteSong(Request $request)
    {
        $id = $request->input('id');
        if ($this->songService->deleteOne($id)) {
            return back()->with('success', config('adm.song.MESSAGE.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.song.MESSAGE.DELETE_FAIL'));
    }

    public function deleteMultipleSong(Request $request)
    {
        $ids = $request->input('ids');
        $this->songService->deleteAll(['id' => $ids]);
        return redirect()->route('adm-manager-song', ['page' => 1])
                         ->with('success', config('adm.song.MESSAGE.DELETE_SUCCESS'));
    }
}