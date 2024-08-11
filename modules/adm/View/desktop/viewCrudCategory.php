<?php

$_namespace = 'adm.viewCrudCategory';

push($_namespace);

echo asset('adm/js/convert-slug.js');
echo asset('adm/js/checkbox.js');

endpush();

$component = _namespace('adm.components.form-crud-category');

require _namespace('layout.desktop-adm');