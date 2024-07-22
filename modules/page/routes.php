<?php

use Foundation\Support\Facades\Route;
use Modules\Page\Controller\PageController;

Route::get('/', [PageController::class, 'index'])->middleware('auth.remember')->name('index');
Route::get('{slug}', [PageController::class, 'page'])->name('page');
Route::get('render-data-page/{slug}', [PageController::class, 'renderDataPage'])->name('render-data-page');

Route::middleware('auth.user')->group(function () {
    Route::get('dashboard', [PageController::class, 'dashboard'])->name('dashboard');
});