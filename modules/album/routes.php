<?php

use Foundation\Support\Facades\Route;
use Modules\Album\Controller\AlbumManageController;

Route::middleware('auth.admin')->group(function () {
    Route::prefix('albums')->group(function () {
        Route::get('list/{page?}', [AlbumManageController::class, 'pageManageAlbum'])
            ->where('page', 'page-(\d+)')
            ->name('adm-manage-album');
        Route::get('edit/{id}', [AlbumManageController::class, 'pageEditAlbum'])->name('adm-edit-album');
        Route::get('{id}/add-song', [AlbumManageController::class, 'pageAddSong'])->name('adm-add-song');
    });

    Route::prefix('api/albums')->group(function () {
        Route::post('create', [AlbumManageController::class, 'createAlbum'])->name('adm-create-album');
        Route::put('update/{id}', [AlbumManageController::class, 'updateAlbum'])->name('adm-update-album');
        Route::delete('delete/{id}', [AlbumManageController::class, 'deleteAlbum'])->name('adm-delete-album');
        // Route::post('delete-multiple', [AlbumManageController::class, 'deleteMultipleAlbum'])->name('adm-delete-multiple-album');
        Route::get('q/{name}', [AlbumManageController::class, 'searchByAlbumName'])->name('adm-search-by-album-name');
    });
});