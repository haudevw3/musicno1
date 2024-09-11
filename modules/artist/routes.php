<?php

use Foundation\Support\Facades\Route;
use Modules\Artist\Controller\ArtistManageController;

Route::middleware('auth.admin')->group(function () {
    Route::prefix('artists')->group(function () {
        Route::get('list/{page?}', [ArtistManageController::class, 'pageManageArtist'])
            ->where('page', 'page-(\d+)')
            ->name('adm-manage-artist');
        Route::get('add', [ArtistManageController::class, 'pageAddArtist'])->name('adm-add-artist');
        Route::get('edit/{id}', [ArtistManageController::class, 'pageEditArtist'])->name('adm-edit-artist');
        Route::get('{id}/add-album', [ArtistManageController::class, 'pageAddAlbum'])->name('adm-add-album');
    });

    Route::prefix('api/artists')->group(function () {
        Route::post('create', [ArtistManageController::class, 'createArtist'])->name('adm-create-artist');
        Route::put('update/{id}', [ArtistManageController::class, 'updateArtist'])->name('adm-update-artist');
        Route::delete('delete/{id}', [ArtistManageController::class, 'deleteArtist'])->name('adm-delete-artist');
        Route::post('delete-multiple', [ArtistManageController::class, 'deleteMultipleArtist'])->name('adm-delete-multiple-artist');
        Route::get('q/{name}', [ArtistManageController::class, 'searchByArtistName'])->name('adm-search-by-artist-name');
    });
});