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
        $pagination = $this->songService->getListPagination(
            ['id', 'name', 'duration', 'created_at', 'updated_at'],
            empty($albumId) ? [] : ['album_id' => $albumId]
        );
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
        $tags = is_null($song['tags']) ? [] : explode(',', $song['tags']);
        $artists = $this->artistService->findAll(['id', 'name']);
        $artistIds = explode(',', $song['artist_ids']);
        foreach ($artists as $key => $artist) {
            if ($artist['id'] == $artistIds[0] && $key > 0) {
                $temp = $artists[0];
                $artists[0] = $artist;
                $artists[$key] = $temp;
            }
        }
        $data = [
            'label' => 2,
            'title' => 'Cập nhật bài hát',
            'song' => $song,
            'artists' => $artists,
            'artistIds' => $artistIds,
            'tags' => $tags,
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
            $data['duration'] = tap(new MP3(public_path("uploads/audio/$fileName")), function ($mp3) use (&$duration) {
                $duration = $mp3->duration();
            })->format($duration);
        } else {
            $data['audio'] = $data['audio_url'];
        }
        unset($data['id'], $data['image_url'], $data['audio_url']);
        $data['artist_ids'] = implode(',', $data['artist_ids']);
        $data['tags'] = isset($data['tags']) ? implode(',', $data['tags']) : null;
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