<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreatePlaylist;
use Modules\Playlist\Service\PlaylistService;
use Foundation\Support\Str;
use Modules\Adm\Request\FormUpdatePlaylist;
use Modules\Album\Service\AlbumService;

class PlaylistManageController
{
    protected $playlistService;
    protected $albumService;

    public function __construct(PlaylistService $playlistService, AlbumService $albumService)
    {
        $this->playlistService = $playlistService;
        $this->albumService = $albumService;
    }

    public function pageManagePlaylist()
    {
        $pagination = $this->playlistService->listPlaylist();
        $playlists = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
            'title' => 'Bảng dữ liệu danh sách phát',
            'playlists' => $playlists,
            'pagination' => $pagination,
            'dialog' => config('adm.playlist.MESSAGES.DIALOG'),
        ];
        return view('adm.viewManagePlaylist', $data);
    }

    public function pageAddPlaylist()
    {
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu tạo danh sách phát',
        ];
        return view('adm.viewCrudPlaylist', $data);
    }

    public function createPlaylist(FormCreatePlaylist $request)
    {
        $validated = $request->validated();
        if (is_array($validated) || ! $request->hasFile('image')) {
            return back()->with('fail', config('adm.playlist.MESSAGES.CREATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $data['playlist_id'] = Str::random(22);
        $fileName = $request->file('image')->hash()->move('public/uploads/images');
        $data['image'] = asset("uploads/images/$fileName");
        $this->playlistService->create($data);
        return redirect()->route('adm-manage-playlist', ['page' => 1])
                         ->with('success', config('adm.playlist.MESSAGES.CREATE_SUCCESS'));
    }

    public function pageEditPlaylist(Request $request)
    {
        $id = $request->input('id');
        $playlist = $this->playlistService->findOne(['id' => $id]);
        $data = [
            'label' => 2,
            'title' => 'Cập nhật danh sách phát',
            'playlist' => $playlist,
        ];
        return view('adm.viewCrudPlaylist', $data);
    }

    public function updatePlaylist(FormUpdatePlaylist $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return back()->with('fail', config('adm.playlist.MESSAGE.UPDATE_FAIL'))
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
        unset($data['id'], $data['image_url']);
        $this->playlistService->updateOne($id, $data);
        return redirect()->route('adm-manage-playlist', ['page' => 1])
                         ->with('success', config('adm.playlist.MESSAGES.UPDATE_SUCCESS'));
    }

    public function deletePlaylist(Request $request)
    {
        $id = $request->input('id');
        if ($this->playlistService->deleteOne($id)) {
            return back()->with('success', config('adm.playlist.MESSAGES.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.playlist.MESSAGES.DELETE_FAIL'));
    }

    public function deleteMultiplePlaylist(Request $request)
    {
        $ids = $request->input('playlist_ids');
        $this->playlistService->deleteAll(['id' => $ids]);
        return redirect()->route('adm-manage-playlist', ['page' => 1])
                         ->with('success', config('adm.playlist.MESSAGES.DELETE_SUCCESS'));
    }

    public function pageChooseAlbum(Request $request)
    {
        $id = $request->input('id');
        $playlist = $this->playlistService->findOne(['id' => $id]);
        $albums = $this->albumService->findAll(['id', 'name']);
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu chọn album cho danh sách phát',
            'id' => $id,
            'albums' => $albums,
            'albumIds' => explode(',', $playlist['album_ids']),
        ];
        return view('adm.viewChooseAlbumForPlaylist', $data);
    }

    public function updateAlbumForPlaylist(Request $request)
    {
        if (empty($request->input('album_ids'))) {
            return back()->with('fail', config('adm.playlist.MESSAGES.CHOOSE_ALBUM_FOR_PLAYLIST_FAIL'));
        }
        $id = $request->input('id');
        $albumIds = implode(',', $request->input('album_ids'));
        $this->playlistService->updateOne($id, ['album_ids' => $albumIds]);
        return redirect()->route('adm-manage-playlist', ['page' => 1])
                         ->with('success', config('adm.playlist.MESSAGES.CHOOSE_ALBUM_FOR_PLAYLIST_SUCCESS'));
    }
}