<?php

use Illuminate\Support\Facades\Route;
use Modules\Artist\Controllers\ArtistManagerController;

Route::middleware('demon')->group(function () {

    Route::prefix('artists')->middleware('auth.admin.custom')->group(function() {
        Route::get('add', [ArtistManagerController::class, 'pageAddArtist'])->name('adm-add-artist');
        Route::get('edit/{id}', [ArtistManagerController::class, 'pageEditArtist'])->name('adm-edit-artist');
    });

    Route::prefix('api/v1/artists')->middleware('auth.admin.api')->group(function() {
        Route::post('create', [ArtistManagerController::class, 'createArtistApi']);
        Route::put('update', [ArtistManagerController::class, 'updateArtistApi']);
        Route::delete('delete', [ArtistManagerController::class, 'deleteArtistApi']);
    });
});