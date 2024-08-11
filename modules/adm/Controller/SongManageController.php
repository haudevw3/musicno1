<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormUpdateSong;
use Modules\Album\Service\AlbumService;
use Modules\Artist\Service\ArtistService;
use Modules\Song\Object\MP3;
use Modules\Song\Service\SongService;

class SongManageController
{
    protected $songService;
    protected $albumService;
    protected $artistService;

    public function __construct(SongService $songService, AlbumService $albumService, ArtistService $artistService)
    {
        $this->songService = $songService;
        $this->albumService = $albumService;
        $this->artistService = $artistService;
    }

    public function pageManageSong(Request $request)
    {
        $albumId = $request->input('album_id');
        $pagination = $this->songService->listSong([], ! empty($albumId) ? ['album_id' => $albumId] : []);
        $songs = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
            'title' => 'Bảng dữ liệu bài hát',
            'songs' => $songs,
            'pagination' => $pagination,
            'dialog' => config('adm.song.MESSAGES.DIALOG'),
        ];
        return view('adm.viewManageSong', $data);
    }

    public function pageEditSong(Request $request)
    {
        $id = $request->input('id');
        $song = $this->songService->findOne(['id' => $id]);
        $artist = $this->artistService->findOne(['id' => $song['artist_id']]);
        $artists = $this->artistService->findAll(['id', 'name']);
        foreach ($artists as $key => $value) {
            if ($value['id'] == $artist['id']) {
                unset($artists[$key]);
                break;
            }
        }
        $data = [
            'label' => 2,
            'title' => 'Cập nhật bài hát',
            'song' => $song,
            'artists' => $artists,
            'contributingArtistId' => explode(',', $song['contributing_artist_ids']),
        ];
        return view('adm.viewCrudSong', $data);
    }

    public function updateSong(FormUpdateSong $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return back()->with('fail', config('adm.song.MESSAGE.UPDATE_FAIL'))
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
        if ($request->hasFile('audio')) {
            $fileName = $request->file('audio')->hash()->move('public/uploads/audio');
            $data['audio'] = asset("uploads/audio/$fileName");
            $duration = 0;
            $mp3 = tap(new MP3(public_path("uploads/audio/$fileName")), function ($mp3) use (&$duration) {
                $duration = $mp3->duration();
            });
            $data['duration'] = $mp3->format($duration);
        } else {
            $data['audio'] = $data['audio_url'];
        }
        unset($data['image_url'], $data['audio_url']);
        if (! isset($data['contributing_artist_ids'])) {
            $data['contributing_artist_ids'] = null;
        } else {
            $data['contributing_artist_ids'] = implode(',', $data['contributing_artist_ids']);
        }
        $this->songService->updateOne($id, $data);
        return redirect()->route('adm-manage-song', ['page' => 1])
                         ->with('success', config('adm.song.MESSAGES.UPDATE_SUCCESS'));
    }

    public function deleteSong(Request $request)
    {
        $id = $request->input('id');
        $song = $this->songService->findOne(['id' => $id]);
        $album = $this->albumService->findOne(['id' => $song['album_id']]);
        $songIds = explode(',', $album['song_ids']);
        foreach ($songIds as $key => $value) {
            if ($id == $value) {
                unset($songIds[$key]);
            }
        }
        $songIds = empty($songIds) ? null : implode(',', $songIds);
        if ($this->songService->deleteOne($id)) {
            $this->albumService->updateOne($album['id'], ['song_ids' => $songIds]);
            return back()->with('success', config('adm.song.MESSAGES.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.song.MESSAGES.DELETE_FAIL'));
    }
}