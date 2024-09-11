<?php

$_namespace = 'categories.viewManageCategory';

push($_namespace);

echo asset('js/table.js');
echo asset('js/categories/table-manage-category.js');

endpush();

$components = [
    _namespace('components.adm.modal-dialog'),
    _namespace('categories.components.table-manage-category'),
];

require _namespace('layout.desktop-adm');