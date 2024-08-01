<?php

namespace Modules\Playlist\Controller;

use Foundation\Http\Request;
use Modules\Playlist\Service\PlaylistService;

class PlaylistController
{
    protected $playlistService;

    public function __construct(PlaylistService $playlistService)
    {
        $this->playlistService = $playlistService;
    }

    public function playlistDetailPage(Request $request)
    {
        $id = $request->input('id');
        $playlist = $this->playlistService->findOne(['playlist_id' => $id]);
        $songs = $this->playlistService->getListSongByPlaylistId($playlist['id']);
        $duration = 0;
        foreach ($songs as $song) {
            $duration += convertToDuration($song['duration']);
        }
        $playlist['duration'] = convertSecondsToTime($duration);
        $playlist['songs'] = $songs;
        return view('playlist.viewPlaylistDetailPage', compact('playlist'));
    }

    public function renderListSong(Request $request)
    {
        $id = $request->input('id');
        $id = $this->playlistService->findOne(['playlist_id' => $id])['id'];
        $data = $this->playlistService->getListSongByPlaylistId($id);
        return response()->json($data);
    }
}