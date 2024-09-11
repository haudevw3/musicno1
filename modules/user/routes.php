<?php

use Foundation\Support\Facades\Route;
use Modules\User\Controller\UserController;
use Modules\User\Controller\UserManageController;

Route::get('dang-nhap', [UserController::class, 'pageLogin'])->name('page-login');
Route::get('dang-ky', [UserController::class, 'pageRegister'])->name('page-register');
Route::post('post-login', [UserController::class, 'login'])->name('login');
Route::post('post-register', [UserController::class, 'register'])->name('register');
Route::get('logout', [UserController::class, 'logout'])->name('logout');
Route::get('thong-tin-ca-nhan', [UserController::class, 'profile'])->name('profile');

Route::middleware('auth.admin')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('list/{page?}', [UserManageController::class, 'pageManageUser'])
            ->where('page', 'page-(\d+)')
            ->name('adm-manage-user');
        Route::get('add', [UserManageController::class, 'pageAddUser'])->name('adm-add-user');
        Route::get('edit/{id}', [UserManageController::class, 'pageEditUser'])->name('adm-edit-user');
    });

    Route::prefix('api/users')->group(function () {
        Route::post('create', [UserManageController::class, 'createUser'])->name('adm-create-user');
        Route::put('update/{id}', [UserManageController::class, 'updateUser'])->name('adm-update-user');
        Route::delete('delete/{id}', [UserManageController::class, 'deleteUser'])->name('adm-delete-user');
        Route::post('delete-multiple', [UserManageController::class, 'deleteMultipleUser'])->name('adm-delete-multiple-user');
    });
});
