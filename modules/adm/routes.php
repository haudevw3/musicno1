<?php

use Foundation\Support\Facades\Route;
use Modules\Adm\Controller\AdmController;
use Modules\Adm\Controller\CategoriesManagerController;
use Modules\Adm\Controller\UserManagerController;

Route::prefix('adm')->group(function () {
    Route::get('home', [AdmController::class, 'pageHome'])->name('adm-page');
    Route::get('manager-user/{page?}', [UserManagerController::class, 'pageManagerUser'])
            ->where('page', 'page-(\d+)')
            ->name('adm-manager-user');
    Route::get('page-add-user', [UserManagerController::class, 'pageAddUser'])->name('adm-add-user');
    Route::post('create-user', [UserManagerController::class, 'createUser'])->name('adm-create-user');
    Route::get('page-edit-user/{id?}', [UserManagerController::class, 'pageEditUser'])
            ->where('id', '(\d+)')
            ->name('adm-edit-user');
    Route::post('update-user', [UserManagerController::class, 'updateUser'])->name('adm-update-user');
    Route::get('delete-user/{id}', [UserManagerController::class, 'deleteUser'])->name('adm-delete-user');
    Route::post('delete-multiple-user', [UserManagerController::class, 'deleteMultipleUser'])->name('adm-delete-multiple-user');

    Route::get('manager-categories/{page?}', [CategoriesManagerController::class, 'pageManagerCategories'])
            ->where('page', 'page-(\d+)')
            ->name('adm-manager-categories');
    Route::get('page-add-category', [CategoriesManagerController::class, 'pageAddCategory'])->name('adm-add-category');
    Route::post('create-category', [CategoriesManagerController::class, 'createCategory'])->name('adm-create-category');
    Route::get('page-edit-category/{id?}', [CategoriesManagerController::class, 'pageEditCategory'])
            ->where('id', '(\d+)')
            ->name('adm-edit-category');
    Route::post('update-category', [CategoriesManagerController::class, 'updateCategory'])->name('adm-update-category');
    Route::get('delete-category/{id}', [CategoriesManagerController::class, 'deleteCategory'])->name('adm-delete-category');
    Route::post('delete-multiple-category', [CategoriesManagerController::class, 'deleteMultipleCategory'])->name('adm-delete-multiple-category');
});