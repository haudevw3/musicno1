<?php

use Foundation\Support\Facades\Route;
use Modules\Categories\Controller\CategoryManageController;

Route::middleware('auth.admin')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::get('list/{page?}', [CategoryManageController::class, 'pageManageCategory'])
            ->where('page', 'page-(\d+)')
            ->name('adm-manage-category');
        Route::get('add', [CategoryManageController::class, 'pageAddCategory'])->name('adm-add-category');
        Route::get('edit/{id}', [CategoryManageController::class, 'pageEditCategory'])->name('adm-edit-category');
    });

    Route::prefix('api/categories')->group(function () {
        Route::post('create', [CategoryManageController::class, 'createCategory'])->name('adm-create-category');
        Route::put('update/{id}', [CategoryManageController::class, 'updateCategory'])->name('adm-update-category');
        Route::delete('delete/{id}', [CategoryManageController::class, 'deleteCategory'])->name('adm-delete-category');
        Route::post('delete-multiple', [CategoryManageController::class, 'deleteMultipleCategory'])->name('adm-delete-multiple-category');
    });
});

