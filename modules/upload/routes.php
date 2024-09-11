<?php

use Foundation\Support\Facades\Route;
use Modules\Upload\Controller\UploadController;

Route::prefix('api/upload')->middleware('auth.admin')->group(function () {
    Route::get('list', [UploadController::class, 'listDetailFile'])->name('adm-manage-file');
    Route::post('create', [UploadController::class, 'createFile'])->name('adm-create-file');
});