<?php

return [

    'tag_types' => [
        'Primary',
        'Playlist',
        'Album',
        'Artist',
    ],

    'label' => [
        'EXISTED_NAME' => 'Tên danh mục đã tồn tại. Vui lòng chọn tên danh mục khác.',

        'CREATE_SUCCESS' => 'Tạo danh mục thành công.',

        'UPDATE_SUCCESS' => 'Cập nhật danh mục thành công.',

        'DELETE_SUCCESS' => 'Xóa danh mục thành công.',
        
        'NOT_FOUND_CATEGORY' => 'Không tìm thấy danh mục.',

        'CATEGORY_DEPENDENCY_PRIMARY_TYPE' => 'Danh mục {name} đang chứa các danh mục phụ thuộc loại Primary.
                                               Vui lòng chọn loại danh mục là Primary để thực hiện chức năng này.',
        
        'CATEGORY_DEPENDENCY_NON_PRIMARY_TYPE' => 'Danh mục {name} đang chứa các danh mục phụ thuộc không phải là loại Primary.
                                                   Vui lòng chọn loại danh mục như Playlist, Album, Artist thực hiện chức năng này.',

        'CATEGORY_UPDATE_BLOCKED_DEPENDENCIES' => 'Không thể cập nhật danh mục này bởi vì danh mục đang chứa các phụ thuộc khác.
                                                   Vui lòng vào các danh mục phụ thuộc để hủy danh mục chính và thực hiện lại chức năng này nếu cần.',
    ],
];