<?php

return [
    'artist' => [
        'table' => [
            'column' => ['STT', 'Tên nghệ sĩ', 'Tiểu sử - Mô tả', 'Danh mục', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'action' => [
            'them-nghe-si' => ['title' => 'Thêm nghệ sĩ', 'icon' => 'fa-solid fa-user-music', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-artist']],
            'xoa-nhanh' => ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-artist', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-artist']]
        ],

        'MESSAGE' => [
            'CREATE_SUCCESS' => 'Tạo nghệ sĩ thành công.',
            'CREATE_FAIL' => 'Tạo nghệ sĩ thất bại. Vui lòng kiểm tra lại các thông tin.',
            'UPDATE_SUCCESS' => 'Cập nhật dữ liệu nghệ sĩ thành công.',
            'UPDATE_FAIL' => 'Cập nhật dữ liệu nghệ sĩ thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DELETE_SUCCESS' => 'Xóa dữ liệu nghệ sĩ thành công.',
            'DELETE_FAIL' => 'Xóa dữ liệu nghệ sĩ thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DIALOG' => 'Bạn có chắc muốn xóa dữ liệu nghệ sĩ này không? Khi xóa mọi dữ liệu liên quan đến nghệ sĩ này sẽ bị mất.',
        ]
    ],

    'categories' => [

        'table' => [
            'column' => ['STT', 'Tên danh mục', 'Đường dẫn hiển thị', 'Độ ưu tiên', 'Danh mục', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'action' => [
            'them-danh-muc' => ['title' => 'Thêm danh mục', 'icon' => 'fa-regular fa-layer-plus', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-category']],
            'xoa-nhanh' => ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-category', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-category']]
        ],

        'MESSAGE' => [
            'CREATE_SUCCESS' => 'Tạo danh mục thành công.',
            'CREATE_FAIL' => 'Tạo danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
            'UPDATE_SUCCESS' => 'Cập nhật dữ liệu danh mục thành công.',
            'UPDATE_FAIL' => 'Cập nhật dữ liệu danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DELETE_SUCCESS' => 'Xóa dữ liệu danh mục thành công.',
            'DELETE_FAIL' => 'Xóa dữ liệu danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DIALOG' => 'Bạn có chắc muốn xóa dữ liệu danh mục này không? Khi xóa mọi dữ liệu liên quan đến danh mục này sẽ bị mất.',
        ],
    ],

    'song' => [

        'table' => [
            'column' => ['STT', 'Tên bài hát', 'Nghệ sĩ', 'Đóng góp chung', 'Thời gian', 'Danh mục', 'Ngày tạo', 'Cập nhật gần đây', 'Hành động'],
        ],

        'action' => [
            'them-bai-hat' => ['title' => 'Thêm bài hát', 'icon' => 'fa-regular fa-compact-disc', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-song']],
            'xoa-nhanh' => ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-song', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-song']]
        ],

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

        'option' => [
            'doi-mat-khau'  => ['title' => 'Đổi mật khẩu', 'icon' => 'fa-regular fa-key', 'class' => '', 'route' => ['name' => '', 'params' => '']],
        ],

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