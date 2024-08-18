<?php

use Foundation\Support\Facades\Route;
use Modules\Song\Controller\SongController;

Route::get('get-list-song-by-tags/{tags}', [SongController::class, 'getListSongByTags'])->name('get-list-song-by-tags');