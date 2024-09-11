<?php

use Foundation\Support\Facades\Route;
use Modules\Adm\Controller\AdmController;

Route::middleware('auth.admin')->group(function () {
    Route::get('dashboard-manage', [AdmController::class, 'pageManageDashboard'])->name('adm-manage-dashboard');
});