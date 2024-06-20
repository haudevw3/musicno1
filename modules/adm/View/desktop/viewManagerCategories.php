<?php

push('adm.viewManagerCategories');

echo asset('adm/js/categories/categories-manager.js');

endpush();

$_namespace = 'adm.viewManagerCategories';

$component = _namespace('adm.components.table-list-categories');

require _namespace('layout.desktop-adm');