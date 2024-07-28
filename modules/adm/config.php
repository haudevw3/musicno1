<?php

return [
    
    'categories' => [

        'table' => [
            'column' => ['STT', 'Tên danh mục', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'action' => [
            'them-danh-muc' => ['title' => 'Thêm danh mục', 'icon' => 'fa-regular fa-layer-plus', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-category']],
            'xoa-nhanh' => ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-category', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-category']]
        ],

        'option' => [
            'chon-playlist-cho-danh-muc' => ['title' => 'Chọn playlist cho danh mục', 'icon' => 'fa-regular fa-list-music fs-16', 'class' => '', 'route' => ['name' => 'adm-choose-playlist-for-category']],
        ],

        'MESSAGE' => [
            'CREATE_SUCCESS' => 'Tạo danh mục thành công.',
            'CREATE_FAIL' => 'Tạo danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
            'UPDATE_SUCCESS' => 'Cập nhật dữ liệu danh mục thành công.',
            'UPDATE_FAIL' => 'Cập nhật dữ liệu danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DELETE_SUCCESS' => 'Xóa dữ liệu danh mục thành công.',
            'DELETE_FAIL' => 'Xóa dữ liệu danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DIALOG' => 'Bạn có chắc muốn xóa dữ liệu danh mục này không? Khi xóa mọi dữ liệu liên quan đến danh mục này sẽ bị mất.',
            'CHOOSE_PLAYLIST_FOR_CATEGORY_SUCCESS' => 'Cập nhật dữ liệu playlist cho danh mục thành công.',
            'CHOOSE_PLAYLIST_FOR_CATEGORY_FAIL' => 'Cập nhật dữ liệu playlist cho danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
        ],
    ],

    'playlist' => [
        'table' => [
            'column' => ['STT', 'Tên playlist', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'action' => [
            'them-playlist' => ['title' => 'Thêm playlist', 'icon' => 'fa-solid fa-list-music', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-playlist']],
            'xoa-nhanh' => ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-playlist', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-playlist']]
        ],

        'option' => [
            'chon-album-cho-playlist' => ['title' => 'Chọn album cho playlist', 'icon' => 'fa-regular fa-album fs-16', 'class' => '', 'route' => ['name' => 'adm-choose-album-for-playlist']],
        ],

        'MESSAGE' => [
            'CREATE_SUCCESS' => 'Tạo playlist thành công.',
            'CREATE_FAIL' => 'Tạo playlist thất bại. Vui lòng kiểm tra lại các thông tin.',
            'UPDATE_SUCCESS' => 'Cập nhật dữ liệu playlist thành công.',
            'UPDATE_FAIL' => 'Cập nhật dữ liệu playlist thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DELETE_SUCCESS' => 'Xóa dữ liệu playlist thành công.',
            'DELETE_FAIL' => 'Xóa dữ liệu playlist thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DIALOG' => 'Bạn có chắc muốn xóa dữ liệu playlist này không? Khi xóa mọi dữ liệu liên quan đến playlist này sẽ bị mất.',
            'CHOOSE_ALBUM_FOR_PLAYLIST_SUCCESS' => 'Cập nhật dữ liệu album cho playlist thành công.',
            'CHOOSE_ALBUM_FOR_PLAYLIST_FAIL' => 'Cập nhật dữ liệu album cho playlist thất bại. Vui lòng kiểm tra lại các thông tin.',
        ]
    ],

    'artist' => [
        'table' => [
            'column' => ['STT', 'Tên nghệ sĩ', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'action' => [
            'them-nghe-si' => ['title' => 'Thêm nghệ sĩ', 'icon' => 'fa-solid fa-user-music', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-artist']],
            'xoa-nhanh' => ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-artist', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-artist']]
        ],

        'option' => [
            'chon-album-cho-nghe-si' => ['title' => 'Chọn album cho nghệ sĩ', 'icon' => 'fa-regular fa-album fs-16', 'class' => '', 'route' => ['name' => 'adm-choose-album-for-artist']],
        ],

        'MESSAGE' => [
            'CREATE_SUCCESS' => 'Tạo nghệ sĩ thành công.',
            'CREATE_FAIL' => 'Tạo nghệ sĩ thất bại. Vui lòng kiểm tra lại các thông tin.',
            'UPDATE_SUCCESS' => 'Cập nhật dữ liệu nghệ sĩ thành công.',
            'UPDATE_FAIL' => 'Cập nhật dữ liệu nghệ sĩ thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DELETE_SUCCESS' => 'Xóa dữ liệu nghệ sĩ thành công.',
            'DELETE_FAIL' => 'Xóa dữ liệu nghệ sĩ thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DIALOG' => 'Bạn có chắc muốn xóa dữ liệu nghệ sĩ này không? Khi xóa mọi dữ liệu liên quan đến nghệ sĩ này sẽ bị mất.',
            'CHOOSE_ALBUM_FOR_ARTIST_SUCCESS' => 'Cập nhật dữ liệu album cho nghệ sĩ thành công.',
            'CHOOSE_ALBUM_FOR_ARTIST_FAIL' => 'Cập nhật dữ liệu album cho nghệ sĩ thất bại. Vui lòng kiểm tra lại các thông tin.',
        ]
    ],

    'album' => [
        'table' => [
            'column' => ['STT', 'Tên album', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'action' => [
            'them-album' => ['title' => 'Thêm album', 'icon' => 'fa-solid fa-album', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-album']],
            'xoa-nhanh' => ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-album', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-album']]
        ],

        'option' => [
            'chon-bai-hat-cho-album' => ['title' => 'Chọn bài hát cho album', 'icon' => 'fa-regular fa-compact-disc fs-16', 'class' => '', 'route' => ['name' => 'adm-choose-song-for-album']]
        ],

        'MESSAGE' => [
            'CREATE_SUCCESS' => 'Tạo album thành công.',
            'CREATE_FAIL' => 'Tạo album thất bại. Vui lòng kiểm tra lại các thông tin.',
            'UPDATE_SUCCESS' => 'Cập nhật dữ liệu album thành công.',
            'UPDATE_FAIL' => 'Cập nhật dữ liệu album thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DELETE_SUCCESS' => 'Xóa dữ liệu album thành công.',
            'DELETE_FAIL' => 'Xóa dữ liệu album thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DIALOG' => 'Bạn có chắc muốn xóa dữ liệu album này không? Khi xóa mọi dữ liệu liên quan đến album này sẽ bị mất.',
            'CHOOSE_SONG_FOR_ALBUM_SUCCESS' => 'Cập nhật dữ liệu bài hát cho album thành công.',
            'CHOOSE_SONG_FOR_ALBUM_FAIL' => 'Cập nhật dữ liệu bài hát cho album thất bại. Vui lòng kiểm tra lại các thông tin.',
        ]
    ],

    'song' => [

        'table' => [
            'column' => ['STT', 'Tên bài hát', 'Thời gian', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'action' => [
            'them-bai-hat' => ['title' => 'Thêm bài hát', 'icon' => 'fa-regular fa-compact-disc', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-song']],
            'xoa-nhanh' => ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-song', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-song']]
        ],

        'option' => [],

        'MESSAGE' => [
            'CREATE_SUCCESS' => 'Tạo bài hát thành công.',
            'CREATE_FAIL' => 'Tạo bài hát thất bại. Vui lòng kiểm tra lại các thông tin.',
            'UPDATE_SUCCESS' => 'Cập nhật dữ liệu bài hát thành công.',
            'UPDATE_FAIL' => 'Cập nhật dữ liệu bài hát thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DELETE_SUCCESS' => 'Xóa dữ liệu bài hát thành công.',
            'DELETE_FAIL' => 'Xóa dữ liệu bài hát thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DIALOG' => 'Bạn có chắc muốn xóa dữ liệu bài hát này không? Khi xóa mọi dữ liệu liên quan đến bài hát này sẽ bị mất.',
        ]
    ],

    'user' => [

        'table' => [
            'column' => ['STT', 'Họ và tên', 'Tên đăng nhập', 'Email', 'Số điện thoại', 'Trạng thái', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'action' => [
            'them-thanh-vien' => ['title' => 'Thêm thành viên', 'icon' => 'fa-solid fa-user-plus', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-user']],
            'xoa-nhanh' => ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-user', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-user']]
        ],

        'option' => [],

        'MESSAGE' => [
            'CREATE_SUCCESS' => 'Tạo tài khoản người dùng thành công.',
            'CREATE_FAIL' => 'Tạo tài khoản người dùng thất bại. Vui lòng kiểm tra lại các thông tin.',
            'UPDATE_SUCCESS' => 'Cập nhật dữ liệu người dùng thành công.',
            'UPDATE_FAIL' => 'Cập nhật dữ liệu người dùng thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DELETE_SUCCESS' => 'Xóa dữ liệu người dùng thành công.',
            'DELETE_FAIL' => 'Xóa dữ liệu người dùng thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DIALOG' => 'Bạn có chắc muốn xóa dữ liệu người dùng này không? Khi xóa mọi dữ liệu liên quan đến người dùng này sẽ bị mất.',
        ]
    ],
];