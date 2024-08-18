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
        $playlist = $this->playlistService->getListAlbumAndSongById(['playlist_id' => $id], ['playlist_id', 'name', 'image', 'description']);
        return view('playlist.viewPlaylistDetailPage', compact('playlist'));
    }

    public function getListSongForPlaylist(Request $request)
    {
        $id = $request->input('id');
        $data = $this->playlistService->getListAlbumAndSongById(['playlist_id' => $id], ['playlist_id'], true);
        return response()->json($data);
    }
}