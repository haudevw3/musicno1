<?php

push('adm.viewCrudCategory');

echo asset('adm/js/convert-slug.js');
echo asset('adm/js/checkbox.js');

endpush();

$_namespace = 'adm.viewCrudCategory';

$component = _namespace('adm.components.form-crud-category');

require _namespace('layout.desktop-adm');