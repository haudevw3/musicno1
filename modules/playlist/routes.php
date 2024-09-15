<?php

use Foundation\Support\Facades\Route;
use Modules\Playlist\Controller\PlaylistManageController;

Route::middleware('auth.admin')->group(function () {
    Route::prefix('playlists')->group(function () {
        Route::get('list/{page?}', [PlaylistManageController::class, 'pageManagePlaylist'])
            ->where('page', 'page-(\d+)')
            ->name('adm-manage-playlist');
        Route::get('add', [PlaylistManageController::class, 'pageAddPlaylist'])->name('adm-add-playlist');
        Route::get('edit/{id}', [PlaylistManageController::class, 'pageEditPlaylist'])->name('adm-edit-playlist');
    });

    Route::prefix('api/playlists')->group(function () {
        Route::post('create', [PlaylistManageController::class, 'createPlaylist'])->name('adm-create-playlist');
        Route::put('update/{id}', [PlaylistManageController::class, 'updatePlaylist'])->name('adm-update-playlist');
        Route::delete('delete/{id}', [PlaylistManageController::class, 'deletePlaylist'])->name('adm-delete-playlist');
        Route::post('delete-multiple', [PlaylistManageController::class, 'deleteMultiplePlaylist'])->name('adm-delete-multiple-playlist');
        Route::get('q/{name}', [PlaylistManageController::class, 'searchByPlaylistName'])->name('adm-search-by-playlist-name');
    });
});