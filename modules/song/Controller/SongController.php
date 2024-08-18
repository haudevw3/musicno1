<?php

namespace Modules\Song\Controller;

use Foundation\Http\Request;
use Modules\Song\Service\SongService;

class SongController
{
    protected $songService;

    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
    }

    public function getListSongByTags(Request $request)
    {
        $tags = [$request->input('tags')];
        $songs = $this->songService->getListSongByTags($tags, ['name', 'image', 'audio', 'duration', 'artist_ids']);
        return response()->json($songs);
    }
}