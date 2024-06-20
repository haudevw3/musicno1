<?php

push('adm.viewCrudCategory');

echo asset('adm/js/categories/form.js');

endpush();

$_namespace = 'adm.viewCrudCategory';

$component = _namespace('adm.components.form-crud-category');

require _namespace('layout.desktop-adm');