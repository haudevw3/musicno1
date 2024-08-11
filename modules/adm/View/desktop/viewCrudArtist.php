<?php

$_namespace = 'adm.viewCrudArtist';

push($_namespace);

echo asset('adm/js/convert-slug.js');

endpush();

$component = _namespace('adm.components.form-crud-artist');

require _namespace('layout.desktop-adm');