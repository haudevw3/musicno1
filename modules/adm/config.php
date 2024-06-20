<?php

return [
    'user' => [

        'table' => [
            'column' => ['STT', 'Họ và tên', 'Tên đăng nhập', 'Số điện thoại', 'Địa chỉ', 'Email', 'Trạng thái', 'Ngày tạo', 'Hành động'],
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

    'categories' => [

        'table' => [
            'column' => ['STT', 'Tên danh mục', 'Độ ưu tiên', 'Danh mục phụ', 'Chế độ hiện thị', 'Đường dẫn hiển thị', 'Ngày tạo', 'Hành động'],
        ],

        'action' => [
            'them-danh-muc' => ['title' => 'Thêm danh mục', 'icon' => 'fa-regular fa-layer-plus', 'tag' => 'a', 'class' => 'bg-color-blue-01', 'route' => ['name' => 'adm-add-category']],
            'xoa-nhanh' => ['title' => 'Xóa nhanh', 'icon' => 'fa-regular fa-trash', 'class' => 'bg-color-red delete-multiple-category', 'tag' => 'div', 'route' => ['name' => 'adm-delete-multiple-category']]
        ],

        'MESSAGE' => [
            'CREATE_SUCCESS' => 'Tạo tài danh mục thành công.',
            'CREATE_FAIL' => 'Tạo tài danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
            'UPDATE_SUCCESS' => 'Cập nhật dữ liệu danh mục thành công.',
            'UPDATE_FAIL' => 'Cập nhật dữ liệu danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DELETE_SUCCESS' => 'Xóa dữ liệu danh mục thành công.',
            'DELETE_FAIL' => 'Xóa dữ liệu danh mục thất bại. Vui lòng kiểm tra lại các thông tin.',
            'DIALOG' => 'Bạn có chắc muốn xóa dữ liệu danh mục này không? Khi xóa mọi dữ liệu liên quan đến danh mục này sẽ bị mất.',
        ]
    ],
];