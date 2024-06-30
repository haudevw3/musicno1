<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreateSong;
use Modules\Adm\Request\FormUpdateSong;
use Modules\Artist\Service\ArtistService;
use Modules\Categories\Service\CategoriesService;
use Modules\Song\Object\MP3;
use Modules\Song\Service\SongService;

class SongManagerController
{
    protected $songService;
    protected $artistService;
    protected $categoriesService;

    public function __construct(SongService $songService, ArtistService $artistService, CategoriesService $categoriesService)
    {
        $this->songService = $songService;
        $this->artistService = $artistService;
        $this->categoriesService = $categoriesService;
    }

    public function pageManagerSong()
    {
        $pagination = $this->songService->listSong();
        $songs = $pagination['data'];
        unset($pagination['data']);
        foreach ($songs as $key => $song) {
            $songs[$key]['artist_name'] = $this->artistService->findOne(['id' => $song['artist_id']])['name'];
        }
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
        $artists = $this->artistService->findAll(['id','name']);
        $categories = $this->categoriesService->findAll(['id', 'name']);
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu tạo bài hát',
            'artists' => $artists,
            'categories' => $categories,
        ];
        return view('adm.viewCrudSong', $data);
    }

    public function createSong(FormCreateSong $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return back()->with('fail', config('adm.song.MESSAGE.CREATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $fileImage = $request->file('image');
        $fileAudio = $request->file('audio');
        if (! is_null($fileImage)) {
            $fileName = $fileImage->hash()->move('public/uploads/images');
            $data['image'] = asset("uploads/images/$fileName");
        }
        if (! is_null($fileAudio)) {
            $fileName = $fileAudio->hash()->move('public/uploads/audio');
            $data['audio'] = asset("uploads/audio/$fileName");
            $duration = 0;
            $mp3 = tap(new MP3(public_path("uploads/audio/$fileName")), function ($mp3) use (&$duration) {
                $duration = $mp3->duration();
            });
            $data['duration'] = $mp3->format($duration);
        }
        $this->songService->create($data);
        return redirect()->route('adm-manager-song', ['page' => 1])
                         ->with('success', config('adm.song.MESSAGE.CREATE_SUCCESS'));
    }

    public function pageEditSong(Request $request)
    {
        $id = $request->input('id');
        $song = $this->songService->findOne(['id' => $id]);
        $artists = $this->artistService->findAll(['id','name']);
        $categories = $this->categoriesService->findAll(['id','name']);
        $data = [
            'label' => 2,
            'title' => 'Cập nhật bài hát',
            'song' => $song,
            'artists' => $artists,
            'categories' => $categories,
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
        $this->songService->updateOne($id, $data);
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
        if ($this->songService->delete(['id' => $request->all()['ids']])) {
            return redirect()->route('adm-manager-song', ['page' => 1])
                             ->with('success', config('adm.song.MESSAGE.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.song.MESSAGE.DELETE_FAIL'));
    }
}