<?php

push('adm.viewCrudAlbum');

echo asset('adm/js/convert-slug.js');

endpush();

$_namespace = 'adm.viewCrudAlbum';

$component = _namespace('adm.components.form-crud-album');

require _namespace('layout.desktop-adm');