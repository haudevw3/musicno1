<?php

use Foundation\Support\Facades\Route;
use Modules\Album\Controller\AlbumController;

Route::get('album/{id}', [AlbumController::class, 'albumDetailPage'])->name('album-detail-page');
Route::get('get-list-song-for-album/{id}', [AlbumController::class, 'getListSongForAlbum'])->name('get-list-song-for-album');