<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreatePlaylist;
use Modules\Album\Service\AlbumService;
use Modules\Playlist\Service\PlaylistAlbumService;
use Modules\Playlist\Service\PlaylistService;
use Foundation\Support\Str;
use Modules\Adm\Request\FormUpdatePlaylist;

class PlaylistManagerController
{
    protected $playlistService;
    protected $playlistAlbumService;
    protected $albumService;

    public function __construct(PlaylistService $playlistService, PlaylistAlbumService $playlistAlbumService, AlbumService $albumService)
    {
        $this->playlistService = $playlistService;
        $this->playlistAlbumService = $playlistAlbumService;
        $this->albumService = $albumService;
    }

    public function pageManagerPlaylist()
    {
        $pagination = $this->playlistService->listPlaylist();
        $playlists = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
            'title' => 'Bảng dữ liệu playlist',
            'playlists' => $playlists,
            'pagination' => $pagination,
            'dialog' => config('adm.playlist.MESSAGE.DIALOG'),
        ];
        return view('adm.viewManagerPlaylist', $data);
    }

    public function pageAddPlaylist()
    {
        $albums = $this->albumService->findAll(['id', 'name']);
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu tạo playlist',
            'albums' => $albums,
        ];
        return view('adm.viewCrudPlaylist', $data);
    }

    public function createPlaylist(FormCreatePlaylist $request)
    {
        $validated = $request->validated();
        if (is_array($validated) || ! $request->hasFile('image') || empty($request->input('album_ids'))) {
            return back()->with('fail', config('adm.playlist.MESSAGE.CREATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $data['playlist_id'] = Str::random(22);
        $fileName = $request->file('image')->hash()->move('public/uploads/images');
        $data['image'] = asset("uploads/images/$fileName");
        $albumIds = $data['album_ids'];
        $playlist = tap($this->playlistService, function ($subject) use ($data) {
            $subject->create($data);
        })->findOne(['playlist_id' => $data['playlist_id']]);
        foreach ($albumIds as $albumId) {
            $this->playlistAlbumService->create(['playlist_id' => $playlist['id'], 'album_id' => $albumId]);
        }
        return redirect()->route('adm-manager-playlist', ['page' => 1])
                         ->with('success', config('adm.playlist.MESSAGE.CREATE_SUCCESS'));
    }

    public function pageEditPlaylist(Request $request)
    {
        $id = $request->input('id');
        $albums = $this->albumService->findAll(['id', 'name']);
        $playlist = $this->playlistService->findOne(['id' => $id]);
        $playlistAlbums = $this->playlistAlbumService->findAll(['album_id'], ['playlist_id' => $id]);
        $albumIds = [];
        foreach ($playlistAlbums as $value) {
            $albumIds[] = $value['album_id'];
        }
        $data = [
            'label' => 2,
            'title' => 'Cập nhật playlist',
            'playlist' => $playlist,
            'albums' => $albums,
            'albumIds' => $albumIds,
        ];
        return view('adm.viewCrudPlaylist', $data);
    }

    public function updatePlaylist(FormUpdatePlaylist $request)
    {
        $validated = $request->validated();
        if (is_array($validated) || empty($request->input('album_ids'))) {
            return back()->with('fail', config('adm.playlist.MESSAGE.UPDATE_FAIL'))
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
        $albumIds = $data['album_ids'];
        unset($data['album_ids']);
        $this->playlistService->updateOne($id, $data);
        $this->playlistAlbumService->updateAll($id, $albumIds);
        return redirect()->route('adm-manager-playlist', ['page' => 1])
                         ->with('success', config('adm.playlist.MESSAGE.UPDATE_SUCCESS'));
    }

    public function deletePlaylist(Request $request)
    {
        $id = $request->input('id');
        if ($this->playlistService->deleteOne($id)) {
            return back()->with('success', config('adm.playlist.MESSAGE.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.playlist.MESSAGE.DELETE_FAIL'));
    }

    public function deleteMultiplePlaylist(Request $request)
    {
        $ids = $request->input('ids');
        $this->playlistService->deleteAll(['id' => $ids]);
        return redirect()->route('adm-manager-playlist', ['page' => 1])
                         ->with('success', config('adm.playlist.MESSAGE.DELETE_SUCCESS'));
    }
}