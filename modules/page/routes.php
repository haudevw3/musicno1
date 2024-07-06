<?php

use Foundation\Support\Facades\Route;
use Modules\Page\Controller\PageController;

Route::get('/', [PageController::class, 'index'])->middleware('auth.remember')->name('index');
Route::get('load-data-page/{alias}', [PageController::class, 'loadDataPage'])->name('load-data-page');

Route::middleware('auth.user')->group(function () {
    
});