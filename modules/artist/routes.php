<?php

use Foundation\Support\Facades\Route;
use Modules\Artist\Controller\ArtistController;

Route::get('artist/{id}', [ArtistController::class, 'artistDetailPage'])->name('artist-detail-page');