<?php

use Foundation\Support\Facades\Route;
use Modules\User\Controller\LoginController;
use Modules\User\Controller\RegisterController;

Route::get('dang-nhap', [LoginController::class, 'pageLogin'])->name('page-login');
Route::get('dang-ky', [RegisterController::class, 'pageRegister'])->name('page-register');
Route::post('post-login', [LoginController::class, 'login'])->name('login');
Route::post('post-register', [RegisterController::class, 'register'])->name('register');
