<?php

$namespace = 'categories.viewManageCategory';
$mainContent = _namespace('categories.layoutManageCategory');

push($namespace);

echo asset('js/table.js');
echo asset('js/categories/table-manage-category.js');

endpush();

require _namespace('layout.desktop-adm');