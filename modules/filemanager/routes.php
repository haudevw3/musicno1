<?php

use Illuminate\Support\Facades\Route;
use Modules\FileManager\Controllers\FileController;

Route::middleware('demon')->group(function () {

    Route::prefix('api/v1/files')->middleware(['api', 'auth.admin.custom'])->group(function () {
        Route::get('list', [FileController::class, 'getFileListApi']);
        Route::post('upload', [FileController::class, 'uploadFileApi']);
    });
});