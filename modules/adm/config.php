<?php

return [
    
    'categories' => [

        'table' => [
            'columns' => ['STT', 'Tên danh mục', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'actions' => [
            ['title' => 'Thêm danh mục', 'icon' => 'fa-regular fa-layer-plus', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-category']],
            ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-category ml-10', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-category']]
        ],

        'options' => [
            ['title' => 'Chọn danh sách phát', 'icon' => 'fa-regular fa-list-music fs-16', 'class' => '', 'route' => ['name' => 'adm-choose-playlist-for-category']],
            ['title' => 'Quản lý danh sách phát', 'icon' => 'fa-regular fa-list-music fs-16', 'class' => '', 'route' => ['name' => 'adm-manage-playlist', 'params' => ['page' => 1]]],
        ],

        'tags' => [
            1 => 'Trang chủ',
            2 => 'Top bài hát',
            3 => 'Chủ đề & Thể loại',
            4 => 'Thư viện',
            5 => 'Nghe gần đây',
            6 => 'Bài hát yêu thích',
            7 => 'Danh sách phát',
        ],

        'MESSAGES' => [
            'CREATE_SUCCESS' => 'Tạo danh mục thành công.',
            'CREATE_FAIL' => 'Tạo danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
            'UPDATE_SUCCESS' => 'Cập nhật dữ liệu danh mục thành công.',
            'UPDATE_FAIL' => 'Cập nhật dữ liệu danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DELETE_SUCCESS' => 'Xóa dữ liệu danh mục thành công.',
            'DELETE_FAIL' => 'Xóa dữ liệu danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DIALOG' => 'Bạn có chắc muốn xóa dữ liệu danh mục này không? Khi xóa mọi dữ liệu liên quan đến danh mục này sẽ bị mất.',
            'CHOOSE_PLAYLIST_FOR_CATEGORY_SUCCESS' => 'Chọn danh sách phát cho danh mục thành công.',
            'CHOOSE_PLAYLIST_FOR_CATEGORY_FAIL' => 'Chọn danh sách phát cho danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
        ],
    ],

    'playlist' => [
        'table' => [
            'columns' => ['STT', 'Tên danh sách phát', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'actions' => [
            ['title' => 'Thêm danh sách phát', 'icon' => 'fa-solid fa-list-music', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-playlist']],
            ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-playlist ml-10', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-playlist']]
        ],

        'options' => [
            ['title' => 'Chọn album cho danh sách phát', 'icon' => 'fa-regular fa-album-collection fs-16', 'class' => '', 'route' => ['name' => 'adm-choose-album-for-playlist']],
        ],

        'tags' => [
            1 => 'Nổi bật',
        ],

        'MESSAGES' => [
            'CREATE_SUCCESS' => 'Tạo danh sách phát thành công.',
            'CREATE_FAIL' => 'Tạo danh sách phát thất bại. Vui lòng kiểm tra lại các thông tin.',
            'UPDATE_SUCCESS' => 'Cập nhật dữ liệu danh sách phát thành công.',
            'UPDATE_FAIL' => 'Cập nhật dữ liệu danh sách phát thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DELETE_SUCCESS' => 'Xóa dữ liệu danh sách phát thành công.',
            'DELETE_FAIL' => 'Xóa dữ liệu danh sách phát thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DIALOG' => 'Bạn có chắc muốn xóa dữ liệu danh sách phát này không? Khi xóa mọi dữ liệu liên quan đến danh sách phát này sẽ bị mất.',
            'CHOOSE_ALBUM_FOR_PLAYLIST_SUCCESS' => 'Chọn album cho danh sách phát thành công.',
            'CHOOSE_ALBUM_FOR_PLAYLIST_FAIL' => 'Chọn album cho danh sách phát thất bại. Vui lòng kiểm tra lại các thông tin.',
        ]
    ],

    'artist' => [
        'table' => [
            'columns' => ['STT', 'Tên nghệ sĩ', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'actions' => [
            ['title' => 'Thêm nghệ sĩ', 'icon' => 'fa-solid fa-user-music', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-artist']],
            ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-artist ml-10', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-artist']]
        ],

        'options' => [
            ['title' => 'Thêm album', 'icon' => 'fa-regular fa-album fs-16', 'class' => '', 'route' => ['name' => 'adm-add-album']],
            ['title' => 'Quản lý các album', 'icon' => 'fa-regular fa-album-collection fs-16', 'class' => '', 'route' => ['name' => 'adm-manage-album', 'params' => ['page' => 1]]],
        ],

        'tags' => [
            1 => 'Nổi bật',
        ],

        'MESSAGES' => [
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
            'columns' => ['STT', 'Tên album', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'actions' => [],

        'options' => [
            ['title' => 'Thêm bài hát', 'icon' => 'fa-regular fa-compact-disc fs-16', 'class' => '', 'route' => ['name' => 'adm-add-song']],
            ['title' => 'Quản lý bài hát', 'icon' => 'fa-regular fa-list-music fs-16', 'class' => '', 'route' => ['name' => 'adm-manage-song', 'params' => ['page' => 1]]],
        ],

        'types' => [
            1 => ['name' => 'Single', 'describe' => '1 bài hát duy nhất'],
            2 => ['name' => 'EP', 'describe' => 'từ 3 đến 6 bài hát'],
            3 => ['name' => 'Compilation', 'describe' => 'từ 7 bài hát trở lên'],
        ],

        'tags' => [
            1 => 'Nổi bật',
            2 => 'Mới phát hành',
        ],

        'years' => [
            2024, 2023, 2022, 2021, 2020,
            2019, 2018, 2017, 2016, 2015,
            2014, 2013, 2012, 2011, 2010,
        ],

        'MESSAGES' => [
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
            'columns' => ['STT', 'Tên bài hát', 'Thời gian', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'actions' => [],

        'options' => [],

        'tags' => [
            1 => 'Nổi bật',
            2 => 'Nổi bật trên trang chủ',
        ],

        'MESSAGES' => [
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
            'columns' => ['STT', 'Họ và tên', 'Tên đăng nhập', 'Email', 'Số điện thoại', 'Trạng thái', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'actions' => [
            ['title' => 'Thêm thành viên', 'icon' => 'fa-solid fa-user-plus', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-user']],
            ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-user ml-10', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-user']]
        ],

        'options' => [],

        'roles' => [
            1 => 'Quản trị viên',
            2 => 'Thành viên'
        ],

        'MESSAGES' => [
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