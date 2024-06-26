<?php

use Foundation\Support\Facades\Route;
use Modules\User\Controller\UserController;

Route::get('dang-nhap', [UserController::class, 'pageLogin'])->name('page-login');
Route::get('dang-ky', [UserController::class, 'pageRegister'])->name('page-register');
Route::post('post-login', [UserController::class, 'login'])->name('login');
Route::post('post-register', [UserController::class, 'register'])->name('register');
Route::get('logout', [UserController::class, 'logout'])->name('logout');
Route::get('thong-tin-ca-nhan', [UserController::class, 'profile'])->name('profile');
