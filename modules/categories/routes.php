<?php

use Illuminate\Support\Facades\Route;
use Modules\Categories\Controllers\CategoryManagerController;

Route::middleware('demon')->group(function () {

    Route::prefix('categories')->middleware('auth.admin.custom')->group(function () {
        Route::get('add', [CategoryManagerController::class, 'pageAddCategory'])->name('adm-add-category');
        Route::get('edit/{id}', [CategoryManagerController::class, 'pageEditCategory'])->name('adm-edit-category');
    });

    Route::prefix('api/v1/categories')->middleware(['api', 'auth.admin.api'])->group(function () {
        Route::post('create', [CategoryManagerController::class, 'createCategoryApi']);
        Route::put('update', [CategoryManagerController::class, 'updateCategoryApi']);
        Route::delete('delete', [CategoryManagerController::class, 'deleteCategoryApi']);
    });
});