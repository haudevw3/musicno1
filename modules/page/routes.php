<?php

use Foundation\Support\Facades\Route;
use Modules\Page\Controller\PageController;

Route::get('/', [PageController::class, 'home'])->middleware('auth.remember')->name('home');
Route::get('{slug}', [PageController::class, 'page'])->name('page');

Route::middleware('auth.user')->group(function () {
    Route::get('dashboard', [PageController::class, 'dashboard'])->name('dashboard');
});