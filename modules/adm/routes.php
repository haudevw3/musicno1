<?php

use Foundation\Support\Facades\Route;
use Modules\Adm\Controller\AdmController;
use Modules\Adm\Controller\AlbumManagerController;
use Modules\Adm\Controller\ArtistManagerController;
use Modules\Adm\Controller\CategoriesManagerController;
use Modules\Adm\Controller\PlaylistManagerController;
use Modules\Adm\Controller\SongManagerController;
use Modules\Adm\Controller\UserManagerController;

Route::prefix('adm')->middleware('auth.admin')->group(function () {
    Route::get('home', [AdmController::class, 'pageHome'])->name('adm-page');

    Route::get('manager-categories/{page?}', [CategoriesManagerController::class, 'pageManagerCategories'])
                ->where('page', 'page-(\d+)')
                ->name('adm-manager-categories');
    Route::get('page-add-category', [CategoriesManagerController::class, 'pageAddCategory'])->name('adm-add-category');
    Route::post('create-category', [CategoriesManagerController::class, 'createCategory'])->name('adm-create-category');
    Route::get('page-edit-category/{id?}', [CategoriesManagerController::class, 'pageEditCategory'])
                ->where('id', '(\d+)')
                ->name('adm-edit-category');
    Route::post('update-category', [CategoriesManagerController::class, 'updateCategory'])->name('adm-update-category');
    Route::get('delete-category/{id}', [CategoriesManagerController::class, 'deleteCategory'])->name('adm-delete-category');
    Route::post('delete-multiple-category', [CategoriesManagerController::class, 'deleteMultipleCategory'])->name('adm-delete-multiple-category');

    Route::get('manager-playlist/{page?}', [PlaylistManagerController::class, 'pageManagerPlaylist'])
                ->where('page', 'page-(\d+)')
                ->name('adm-manager-playlist');
    Route::get('page-add-playlist', [PlaylistManagerController::class, 'pageAddPlaylist'])->name('adm-add-playlist');
    Route::post('create-playlist', [PlaylistManagerController::class, 'createPlaylist'])->name('adm-create-playlist');
    Route::get('page-edit-playlist/{id?}', [PlaylistManagerController::class, 'pageEditPlaylist'])
                ->where('id', '(\d+)')
                ->name('adm-edit-playlist');
    Route::post('update-playlist', [PlaylistManagerController::class, 'updatePlaylist'])->name('adm-update-playlist');
    Route::get('delete-playlist/{id}', [PlaylistManagerController::class, 'deletePlaylist'])->name('adm-delete-playlist');
    Route::post('delete-multiple-playlist', [PlaylistManagerController::class, 'deleteMultiplePlaylist'])->name('adm-delete-multiple-playlist');

    Route::get('manager-artist/{page?}', [ArtistManagerController::class, 'pageManagerArtist'])
                ->where('page', 'page-(\d+)')
                ->name('adm-manager-artist');
    Route::get('page-add-artist', [ArtistManagerController::class, 'pageAddArtist'])->name('adm-add-artist');
    Route::post('create-artist', [ArtistManagerController::class, 'createArtist'])->name('adm-create-artist');
    Route::get('page-edit-artist/{id?}', [ArtistManagerController::class, 'pageEditArtist'])
                ->where('id', '(\d+)')
                ->name('adm-edit-artist');
    Route::post('update-artist', [ArtistManagerController::class, 'updateArtist'])->name('adm-update-artist');
    Route::get('delete-artist/{id}', [ArtistManagerController::class, 'deleteArtist'])->name('adm-delete-artist');
    Route::post('delete-multiple-artist', [ArtistManagerController::class, 'deleteMultipleArtist'])->name('adm-delete-multiple-artist');

    Route::get('manager-album/{page?}', [AlbumManagerController::class, 'pageManagerAlbum'])
                ->where('page', 'page-(\d+)')
                ->name('adm-manager-album');
    Route::get('page-add-album', [AlbumManagerController::class, 'pageAddAlbum'])->name('adm-add-album');
    Route::post('create-album', [AlbumManagerController::class, 'createAlbum'])->name('adm-create-album');
    Route::get('page-edit-album/{id?}', [AlbumManagerController::class, 'pageEditAlbum'])
                ->where('id', '(\d+)')
                ->name('adm-edit-album');
    Route::post('update-album', [AlbumManagerController::class, 'updateAlbum'])->name('adm-update-album');
    Route::get('delete-album/{id}', [AlbumManagerController::class, 'deleteAlbum'])->name('adm-delete-album');
    Route::post('delete-multiple-album', [AlbumManagerController::class, 'deleteMultipleAlbum'])->name('adm-delete-multiple-album');

    Route::get('manager-song/{page?}', [SongManagerController::class, 'pageManagerSong'])
                ->where('page', 'page-(\d+)')
                ->name('adm-manager-song');
    Route::get('page-add-song', [SongManagerController::class, 'pageAddSong'])->name('adm-add-song');
    Route::post('create-song', [SongManagerController::class, 'createSong'])->name('adm-create-song');
    Route::get('page-edit-song/{id?}', [SongManagerController::class, 'pageEditSong'])
                ->where('id', '(\d+)')
                ->name('adm-edit-song');
    Route::post('update-song', [SongManagerController::class, 'updateSong'])->name('adm-update-song');
    Route::get('delete-song/{id}', [SongManagerController::class, 'deleteSong'])->name('adm-delete-song');
    Route::post('delete-multiple-song', [SongManagerController::class, 'deleteMultipleSong'])->name('adm-delete-multiple-song');

    Route::get('manager-user/{page?}', [UserManagerController::class, 'pageManagerUser'])
                ->where('page', 'page-(\d+)')
                ->name('adm-manager-user');
    Route::get('page-add-user', [UserManagerController::class, 'pageAddUser'])->name('adm-add-user');
    Route::post('create-user', [UserManagerController::class, 'createUser'])->name('adm-create-user');
    Route::get('page-edit-user/{id?}', [UserManagerController::class, 'pageEditUser'])
                ->where('id', '(\d+)')
                ->name('adm-edit-user');
    Route::post('update-user', [UserManagerController::class, 'updateUser'])->name('adm-update-user');
    Route::get('delete-user/{id}', [UserManagerController::class, 'deleteUser'])->name('adm-delete-user');
    Route::post('delete-multiple-user', [UserManagerController::class, 'deleteMultipleUser'])->name('adm-delete-multiple-user');
});