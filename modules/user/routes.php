<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Controllers\SocialiteController;
use Modules\User\Controllers\UserController;

Route::middleware('demon')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('dang-nhap', [UserController::class, 'login'])->name('login-page');
        Route::get('dang-ky', [UserController::class, 'register'])->name('register-page');
        Route::get('quen-mat-khau', [UserController::class, 'forgetPassword'])->name('forget-password');

        Route::prefix('social')->group(function () {
            Route::get('auth/redirect', [SocialiteController::class, 'redirect'])->name('google-redirect');
            Route::get('auth/callback', [SocialiteController::class, 'callback']);
        });

        Route::prefix('api/v1')->middleware('api')->group(function () {
            Route::post('post-login', [UserController::class, 'postLoginApi']);
            Route::post('post-register', [UserController::class, 'postRegisterApi']);
            Route::post('post-forget-password', [UserController::class, 'postForgetPasswordApi']);
        });
    });

    Route::middleware('auth.custom')->group(function () {
        Route::get('xac-thuc-tai-khoan/{id?}', [UserController::class, 'verifyAccountPage'])->name('verify-account-page');
        Route::get('doi-mat-khau/{id?}', [UserController::class, 'changePassword'])->name('change-password');
        Route::get('dang-xuat', [UserController::class, 'logout']);

        Route::prefix('api/v1')->middleware('api')->group(function () {
            Route::post('post-verify-account', [UserController::class, 'postVerifyAccountApi']);
            Route::post('refresh-token-to-send-mail', [UserController::class, 'refreshTokenToSendMailApi']);
        });
    });
});