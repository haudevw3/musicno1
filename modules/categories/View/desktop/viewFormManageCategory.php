<?php

$namespace = 'categories.viewFormManageCategory';
$mainContent = _namespace('categories.layoutFormManageCategory');

push($namespace);

echo asset('js/text-box.js');
echo asset('js/upload/file-manager.js');
echo asset('js/categories/form-manage-category.js');

endpush();

require _namespace('layout.desktop-adm');