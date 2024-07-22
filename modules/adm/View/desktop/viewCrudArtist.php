<?php

push('adm.viewCrudArtist');

echo asset('adm/js/convert-slug.js');
echo asset('adm/js/checkbox.js');

endpush();

$_namespace = 'adm.viewCrudArtist';

$component = _namespace('adm.components.form-crud-artist');

require _namespace('layout.desktop-adm');