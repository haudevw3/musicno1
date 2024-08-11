<?php

$_namespace = 'adm.viewCrudAlbum';

push($_namespace);

echo asset('adm/js/convert-slug.js');

endpush();

$component = _namespace('adm.components.form-crud-album');

require _namespace('layout.desktop-adm');