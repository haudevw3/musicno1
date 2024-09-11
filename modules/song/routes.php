<?php

use Foundation\Support\Facades\Route;
use Modules\Song\Controller\SongManageController;

Route::middleware('auth.admin')->group(function () {
    Route::prefix('songs')->group(function () {
        Route::get('list/{page?}', [SongManageController::class, 'pageManageSong'])
            ->where('page', 'page-(\d+)')
            ->name('adm-manage-song');
        Route::get('edit/{id}', [SongManageController::class, 'pageEditSong'])->name('adm-edit-song');
    });

    Route::prefix('api/songs')->group(function () {
        Route::post('create', [SongManageController::class, 'createSong'])->name('adm-create-song');
        Route::put('update/{id}', [SongManageController::class, 'updateSong'])->name('adm-update-song');
        Route::delete('delete/{id}', [SongManageController::class, 'deleteSong'])->name('adm-delete-song');
        // Route::post('delete-multiple', [SongManageController::class, 'deleteMultipleSong'])->name('adm-delete-multiple-song');
    });
});