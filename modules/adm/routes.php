<?php

use Foundation\Support\Facades\Route;
use Modules\Adm\Controller\AlbumManageController;
use Modules\Adm\Controller\ArtistManageController;
use Modules\Adm\Controller\CategoryManageController;
use Modules\Adm\Controller\DashboardManageController;
use Modules\Adm\Controller\PlaylistManageController;
use Modules\Adm\Controller\SongManageController;
use Modules\Adm\Controller\UserManageController;

Route::middleware('auth.admin')->group(function () {
    Route::get('dashboard-manage', [DashboardManageController::class, 'pageManageDashboard'])->name('adm-manage-dashboard');

    Route::prefix('categories')->group(function () {
        Route::get('list/{page?}', [CategoryManageController::class, 'pageManageCategory'])
                ->where('page', 'page-(\d+)')
                ->name('adm-manage-category');
        Route::get('add', [CategoryManageController::class, 'pageAddCategory'])->name('adm-add-category');
        Route::post('create', [CategoryManageController::class, 'createCategory'])->name('adm-create-category');
        Route::get('edit/{id}', [CategoryManageController::class, 'pageEditCategory'])->name('adm-edit-category');
        Route::post('update', [CategoryManageController::class, 'updateCategory'])->name('adm-update-category');
        Route::get('delete/{id}', [CategoryManageController::class, 'deleteCategory'])->name('adm-delete-category');
        Route::post('delete-multiple', [CategoryManageController::class, 'deleteMultipleCategory'])->name('adm-delete-multiple-category');
        Route::get('{id}/choose-playlist', [CategoryManageController::class, 'pageChoosePlaylist'])->name('adm-choose-playlist-for-category');
        Route::post('update-playlist', [CategoryManageController::class, 'updatePlaylistForCategory'])->name('adm-update-playlist-for-category');
    });

    Route::prefix('playlist')->group(function () {
        Route::get('list/{page?}', [PlaylistManageController::class, 'pageManagePlaylist'])
                ->where('page', 'page-(\d+)')
                ->name('adm-manage-playlist');
        Route::get('add', [PlaylistManageController::class, 'pageAddPlaylist'])->name('adm-add-playlist');
        Route::post('create', [PlaylistManageController::class, 'createPlaylist'])->name('adm-create-playlist');
        Route::get('edit/{id}', [PlaylistManageController::class, 'pageEditPlaylist'])->name('adm-edit-playlist');
        Route::post('update', [PlaylistManageController::class, 'updatePlaylist'])->name('adm-update-playlist');
        Route::get('delete/{id}', [PlaylistManageController::class, 'deletePlaylist'])->name('adm-delete-playlist');
        Route::post('delete-multiple', [PlaylistManageController::class, 'deleteMultiplePlaylist'])->name('adm-delete-multiple-playlist');
        Route::get('{id}/choose-album', [PlaylistManageController::class, 'pageChooseAlbum'])->name('adm-choose-album-for-playlist');
        Route::post('update-album', [PlaylistManageController::class, 'updateAlbumForPlaylist'])->name('adm-update-album-for-playlist');
    });

    Route::prefix('artist')->group(function () {
        Route::get('list/{page?}', [ArtistManageController::class, 'pageManageArtist'])
                ->where('page', 'page-(\d+)')
                ->name('adm-manage-artist');
        Route::get('add', [ArtistManageController::class, 'pageAddArtist'])->name('adm-add-artist');
        Route::post('create', [ArtistManageController::class, 'createArtist'])->name('adm-create-artist');
        Route::get('edit/{id}', [ArtistManageController::class, 'pageEditArtist'])->name('adm-edit-artist');
        Route::post('update', [ArtistManageController::class, 'updateArtist'])->name('adm-update-artist');
        Route::get('delete/{id}', [ArtistManageController::class, 'deleteArtist'])->name('adm-delete-artist');
        Route::post('delete-multiple', [ArtistManageController::class, 'deleteMultipleArtist'])->name('adm-delete-multiple-artist');
        Route::get('{id}/add-album', [ArtistManageController::class, 'pageAddAlbum'])->name('adm-add-album');
        Route::post('create-album', [ArtistManageController::class, 'createAlbum'])->name('adm-create-album');
    });

    Route::prefix('album')->group(function () {
        Route::get('list/{page?}', [AlbumManageController::class, 'pageManageAlbum'])
                ->where('page', 'page-(\d+)')
                ->name('adm-manage-album');
        Route::get('edit/{id}', [AlbumManageController::class, 'pageEditAlbum'])->name('adm-edit-album');
        Route::post('update', [AlbumManageController::class, 'updateAlbum'])->name('adm-update-album');
        Route::get('delete/{id}', [AlbumManageController::class, 'deleteAlbum'])->name('adm-delete-album');
        Route::get('{id}/add-song', [AlbumManageController::class, 'pageAddSong'])->name('adm-add-song');
        Route::post('create-song', [AlbumManageController::class, 'createSong'])->name('adm-create-song');
    });

    Route::prefix('song')->group(function () {
        Route::get('list/{page?}', [SongManageController::class, 'pageManageSong'])
                ->where('page', 'page-(\d+)')
                ->name('adm-manage-song');
        Route::get('edit/{id}', [SongManageController::class, 'pageEditSong'])->name('adm-edit-song');
        Route::post('update', [SongManageController::class, 'updateSong'])->name('adm-update-song');
        Route::get('delete/{id}', [SongManageController::class, 'deleteSong'])->name('adm-delete-song');
    });

    Route::prefix('user')->group(function () {
        Route::get('list/{page?}', [UserManageController::class, 'pageManageUser'])
                ->where('page', 'page-(\d+)')
                ->name('adm-manage-user');
        Route::get('add', [UserManageController::class, 'pageAddUser'])->name('adm-add-user');
        Route::post('create', [UserManageController::class, 'createUser'])->name('adm-create-user');
        Route::get('edit/{id}', [UserManageController::class, 'pageEditUser'])->name('adm-edit-user');
        Route::post('update', [UserManageController::class, 'updateUser'])->name('adm-update-user');
        Route::get('delete/{id}', [UserManageController::class, 'deleteUser'])->name('adm-delete-user');
        Route::post('delete-multiple', [UserManageController::class, 'deleteMultipleUser'])->name('adm-delete-multiple-user');
    });
});