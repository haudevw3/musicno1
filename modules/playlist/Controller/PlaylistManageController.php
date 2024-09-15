<?php

namespace Modules\Playlist\Controller;

use Foundation\Http\Request;
use Modules\Album\Service\AlbumService;
use Modules\Playlist\Request\FormCreatePlaylist;
use Modules\Playlist\Request\FormUpdatePlaylist;
use Modules\Playlist\Service\PlaylistService;

class PlaylistManageController
{
    protected $playlistService;
    protected $albumService;

    public function __construct(PlaylistService $playlistService, AlbumService $albumService)
    {
        $this->playlistService = $playlistService;
        $this->albumService = $albumService;
    }

    public function pageManagePlaylist(Request $request)
    {
        $pagination = $this->playlistService->pagination(['id', 'name', 'created_at', 'updated_at']);
        $playlists = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'playlists' => $playlists,
            'pagination' => $pagination,
        ];
        return view('playlist.viewManagePlaylist', $data);
    }

    public function pageAddPlaylist()
    {
        $data = [
            'title' => 'Tạo danh sách phát',
        ];
        return view('playlist.viewFormManagePlaylist', $data);
    }

    public function createPlaylist(FormCreatePlaylist $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return response()->json($validated, 500);
        }
        $data = $request->all();
        $this->playlistService->create($data);
        return response()->json($data, 201);
    }

    public function pageEditPlaylist(Request $request)
    {
        $id = $request->input('id');
        $playlist = $this->playlistService->findOne(['id' => $id]);
        $albums = [];
        $albumIds = explode(',', $playlist['album_ids']);
        foreach ($albumIds as $albumId) {
            $albums[] = $this->albumService->findOne(['id' => $albumId], ['id', 'name']);
        }
        $data = [
            'title' => 'Cập nhật danh sách phát',
            'playlist' => $playlist,
            'albums' => $albums,
        ];
        return view('playlist.viewFormManagePlaylist', $data);
    }

    public function updatePlaylist(FormUpdatePlaylist $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return response()->json($validated, 500);
        }
        $data = $request->all();
        $id = $data['id'];
        unset($data['id']);
        $this->playlistService->updateOne($id, $data);
        return response()->json($validated);
    }

    public function deletePlaylist(Request $request)
    {
        $id = $request->input('id');
        $this->playlistService->deleteOne($id);
        return response()->json();
    }

    public function deleteMultiplePlaylist(Request $request)
    {
        $playlistIds = $request->input('playlist_ids');
        $playlistIds = is_array($playlistIds) ? $playlistIds : [$playlistIds];
        foreach ($playlistIds as $id) {
            $this->playlistService->deleteOne($id);
        }
        return response()->json();
    }

    public function searchByPlaylistName(Request $request)
    {
        $name = $request->input('name');
        $data = $this->playlistService->findAll(['id', 'name'], ['like' => ['name' => '%'.$name.'%']]);
        return response()->json($data);
    }
}