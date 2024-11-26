<?php

use Illuminate\Support\Facades\Route;
use Modules\Album\Controllers\AlbumManagerController;

Route::middleware('demon')->group(function () {

    Route::prefix('albums')->middleware('auth.admin.custom')->group(function() {
        Route::get('add', [AlbumManagerController::class, 'pageAddAlbum'])->name('adm-add-album');
        Route::get('edit/{id}', [AlbumManagerController::class, 'pageEditAlbum'])->name('adm-edit-album');
    });

    Route::prefix('api/v1/albums')->middleware('auth.admin.api')->group(function () {
        Route::post('create', [AlbumManagerController::class, 'createAlbumApi']);
        Route::put('update', [AlbumManagerController::class, 'updateAlbumApi']);
        Route::delete('delete', [AlbumManagerController::class, 'deleteAlbumApi']);
    });
});