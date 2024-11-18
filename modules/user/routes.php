<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Controllers\SocialiteController;
use Modules\User\Controllers\UserController;
use Modules\User\Controllers\UserManagerController;

Route::middleware('demon')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('dang-nhap', [UserController::class, 'loginPage'])->name('login-page');
        Route::get('dang-ky', [UserController::class, 'registerPage'])->name('register-page');
        Route::get('quen-mat-khau', [UserController::class, 'pageForgetPassword'])->name('page-forget-password');

        Route::prefix('social')->group(function () {
            Route::get('auth/redirect', [SocialiteController::class, 'redirect'])->name('google-redirect');
            Route::get('auth/callback', [SocialiteController::class, 'callback']);
        });

        Route::prefix('api/v1')->middleware('api')->group(function () {
            Route::post('login', [UserController::class, 'loginApi']);
            Route::post('register', [UserController::class, 'registerApi']);
            Route::post('forget-password', [UserController::class, 'forgetPasswordApi']);
        });
    });

    Route::prefix('users')->middleware('auth.admin.custom')->group(function () {
        Route::get('add', [UserManagerController::class, 'pageAddUser'])->name('adm-add-user');
        Route::get('edit/{id}', [UserManagerController::class, 'pageEditUser'])->name('adm-edit-user');
    });

    Route::prefix('api/v1/users')->middleware(['api', 'auth.admin.api'])->group(function () {
        Route::post('create', [UserManagerController::class, 'createUserApi']);
        Route::put('update', [UserManagerController::class, 'updateUserApi']);
        Route::delete('delete', [UserManagerController::class, 'deleteUserApi']);
        Route::post('delete-many', [UserManagerController::class, 'deleteManyUserApi']);
    });

    Route::middleware('auth.custom')->group(function () {
        Route::get('xac-thuc-tai-khoan/{id?}', [UserController::class, 'pageVerifyAccount'])->name('page-verify-account');
        Route::get('doi-mat-khau/{id?}', [UserController::class, 'changePassword'])->name('change-password');
        Route::get('dang-xuat', [UserController::class, 'logout'])->name('logout');

        Route::prefix('api/v1')->middleware('api')->group(function () {
            Route::post('verify-account', [UserController::class, 'verifyAccountApi']);
            Route::post('refresh-token-to-send-mail', [UserController::class, 'refreshTokenToSendMailApi']);
            Route::get('thong-tin-ca-nhan', [UserController::class, 'profile'])->name('profile');
        });
    });
});