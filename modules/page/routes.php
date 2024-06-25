<?php

use Foundation\Support\Facades\Route;
use Modules\Page\Controller\PageController;

Route::get('/', [PageController::class, 'index'])->middleware('auth.remember')->name('index');
Route::get('trang-chu', [PageController::class, 'home'])->name('home');