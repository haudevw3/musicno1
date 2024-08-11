<?php

namespace Modules\Album\Controller;

use Foundation\Http\Request;
use Modules\Album\Service\AlbumService;

class AlbumController
{
    protected $albumService;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    public function albumDetailPage(Request $request)
    {
        $id = $request->input('id');
        $album = $this->albumService->findOne(['album_id' => $id], ['id', 'album_id', 'name', 'type', 'image']);
        $songs = $this->albumService->getListSongByAlbumId($album['id'], ['name', 'image', 'duration']);
        $duration = 0;
        foreach ($songs as $song) {
            $duration += convertToDuration($song['duration']);
        }
        $album['duration'] = convertSecondsToTime($duration);
        if ($album['type'] == 1) {
            $album['artists'] = $songs[0]['artists'];
        } elseif ($album['type'] == 2) {
            $album['artists'] = $songs[0]['artists'];
            if (count($songs[0]['artists']) > 1) {
                $album['artists'] = $songs[0]['artists'][0];
            }
        }
        $album['songs'] = $songs;
        return view('album.viewAlbumDetailPage', compact('album'));
    }

    public function getListSongForAlbum(Request $request)
    {
        $id = $request->input('id');
        $id = $this->albumService->findOne(['album_id' => $id])['id'];
        $data = $this->albumService->getListSongByAlbumId($id);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        // return response()->json($data);
    }
}