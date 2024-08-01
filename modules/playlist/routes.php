<?php

use Foundation\Support\Facades\Route;
use Modules\Playlist\Controller\PlaylistController;

Route::get('render-list-song/{id}', [PlaylistController::class, 'renderListSong'])->name('render-list-song');
Route::get('playlist/{id}', [PlaylistController::class, 'playlistDetailPage'])->name('playlist-detail-page');