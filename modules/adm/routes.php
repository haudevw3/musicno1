<?php

use Illuminate\Support\Facades\Route;
use Modules\Adm\Controllers\AdmController;

Route::middleware(['demon', 'auth.admin.custom'])->group(function () {

    Route::prefix('adm')->group(function () {
        Route::get('dashboard', [AdmController::class, 'dashboard'])->name('dashboard');

        Route::get('manage-user/{page?}', [AdmController::class, 'pageManageUser'])
            ->where('page', regex('page'))
            ->name('adm-manage-user');
        
        Route::get('manage-category/{page?}', [AdmController::class, 'pageManageCategory'])
            ->where('page', regex('page'))
            ->name('adm-manage-category');
    });
});