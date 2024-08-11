<?php

$_namespace = 'adm.viewManageCategory';

push($_namespace);

echo asset('adm/js/categories/categories-manage.js');

endpush();

$component = _namespace('adm.components.table-manage-category');

require _namespace('layout.desktop-adm');