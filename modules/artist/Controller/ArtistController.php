<?php

namespace Modules\Artist\Controller;

use Foundation\Http\Request;
use Modules\Album\Service\AlbumService;
use Modules\Artist\Service\ArtistService;
use Modules\Song\Service\SongService;

class ArtistController
{
    protected $artistService;
    protected $albumService;
    protected $songService;

    public function __construct(ArtistService $artistService, AlbumService $albumService, SongService $songService)
    {
        $this->artistService = $artistService;
        $this->albumService = $albumService;
        $this->songService = $songService;
    }

    public function artistDetailPage(Request $request)
    {
        $id = $request->input('id');
        $artist = $this->artistService->findOne(['artist_id' => $id], ['id', 'name', 'image', 'description', 'album_ids']);
        $albums = $this->albumService->findAll(['album_id', 'name', 'image', 'type', 'release_year'], ['artist_id' => $artist['id']], ['release_year' => 'desc']);
        $albumIds = explode(',', $artist['album_ids']);
        $duration = 0;
        $albumTypeSingleAndEps = [];
        $albumTypeCompilations = [];
        $featuredSongs = [];
        foreach ($albumIds as $albumId) {
            $song = $this->songService->findOne(['album_id' => $albumId], ['name', 'image', 'audio', 'duration', 'tags', 'artist_ids']);
            $tags = is_null($song['tags']) ? null : explode(',', $song['tags']);
            $duration += convertToDuration($song['duration']);
            $artistIds = explode(',', $song['artist_ids']);
            foreach ($artistIds as $artistId) {
                $song['artists'][] = $this->artistService->findOne(['id' => $artistId], ['artist_id', 'name']);
            }
            if (! is_null($tags)) {
                foreach ($tags as $tag) {
                    if ($tag == 1) {
                        $featuredSongs[] = $song;
                    }
                }
            }
        }
        foreach ($albums as $key => $album) {
            if (in_array($album['type'], [1, 2])) {
                if ($key == 6) break;
                $albumTypeSingleAndEps[] = $album;
            } else {
                $albumTypeCompilations[] = $album;
            }
        }

        $artist['total'] = count($albumIds);
        $artist['duration'] = convertSecondsToTime($duration);
        $artist[1] = [
            'id' => 'Rk8dOsoNGaRTIhLhE9YlaQ',
            'name' => 'Bài hát nổi bật',
            'songs' => $featuredSongs,
        ];
        $artist[2] = [
            0 => [
                'name' => 'Single & EP',
                'albums' => $albumTypeSingleAndEps,
            ]
        ];

        return view('artist.viewArtistDetailPage', compact('artist'));
    }
}