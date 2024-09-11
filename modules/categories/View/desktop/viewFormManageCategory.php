<?php

$_namespace = 'categories.viewFormManageCategory';

push($_namespace);

echo asset('js/categories/form-manage-category.js');
echo asset('js/upload/file-manager.js');

endpush();

$components = [
    _namespace('components.adm.file-manager'),
    _namespace('categories.components.form-manage-category'),
];

require _namespace('layout.desktop-adm');