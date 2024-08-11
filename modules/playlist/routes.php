<?php

use Foundation\Support\Facades\Route;
use Modules\Playlist\Controller\PlaylistController;

Route::get('playlist/{id}', [PlaylistController::class, 'playlistDetailPage'])->name('playlist-detail-page');
Route::get('get-list-song-for-playlist/{id}', [PlaylistController::class, 'getListSongForPlaylist'])->name('get-list-song-for-playlist');