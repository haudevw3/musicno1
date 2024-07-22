<?php

use Foundation\Support\Facades\Route;
use Modules\Categories\Controller\CategoriesController;

Route::get('categories/{id}', [CategoriesController::class, 'renderDataCategory'])->name('render-data-category');
Route::get('category-with-list-song/{cate_id}', [CategoriesController::class, 'renderDataCategoryWithListSong'])->name('render-data-category-with-list-song');

