<?php

namespace Modules\Song\Controller;

use Foundation\Http\Request;
use Modules\Album\Service\AlbumService;
use Modules\Artist\Service\ArtistService;
use Modules\Song\Object\MP3;
use Modules\Song\Request\FormCreateSong;
use Modules\Song\Request\FormUpdateSong;
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
        $pagination = $this->songService->pagination(
            ['id', 'name', 'duration', 'created_at', 'updated_at'],
            empty($albumId) ? [] : ['album_id' => $albumId]
        );
        $songs = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
            'songs' => $songs,
            'pagination' => $pagination,
        ];
        return view('song.viewManageSong', $data);
    }

    public function createSong(FormCreateSong $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return response()->json($validated, 500);
        }
        $duration = 0;
        $data = $request->all();
        $data['duration'] = tap(new MP3($data['audio']), function ($mp3) use (&$duration) {
            $duration = $mp3->duration();
        })->format($duration);
        $song = $this->songService->create($data);
        $this->albumService->updateOne($song['album_id'], ['song_id' => $song['id']]);
        return response()->json(null, 201);
    }

    public function pageEditSong(Request $request)
    {
        $id = $request->input('id');
        $song = $this->songService->findOne(['id' => $id]);
        $subArtists = [];
        $subArtistIds = explode(',', $song['sub_artist_ids']);
        foreach ($subArtistIds as $key => $value) {
            $subArtists[] = $this->artistService->findOne(['id' => $value], ['id', 'name']);
        }
        $data = [
            'label' => 2,
            'title' => 'Cập nhật bài hát',
            'song' => $song,
            'subArtists' => $subArtists,
        ];
        return view('song.viewFormManageSong', $data);
    }

    public function updateSong(FormUpdateSong $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return response()->json($validated, 500);
        }
        $data = $request->all();
        $id = $data['id'];
        unset($data['id']);
        $this->songService->updateOne($id, $data);
        return response()->json($validated);
    }

    public function deleteSong(Request $request)
    {
        $id = $request->input('id');
        $song = $this->songService->deleteOne($id);
        $this->albumService->deleteOne($song['id']);
        return response()->json();
    }
}