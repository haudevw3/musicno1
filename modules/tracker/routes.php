<?php

use Illuminate\Support\Facades\Route;
use Modules\Tracker\Controllers\UserTrackingLogController;

Route::middleware('demon')->group(function () {

    Route::prefix('api/v1/tracker')->middleware('api')->group(function () {

        Route::prefix('user-tracking-logs')->group(function() {
            Route::post('create', [UserTrackingLogController::class, 'createUserTrackingLogApi']);
        });
    });
});