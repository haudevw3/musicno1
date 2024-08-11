<?php

$_namespace = 'adm.viewCrudPlaylist';

push($_namespace);

echo asset('adm/js/convert-slug.js');

endpush();

$component = _namespace('adm.components.form-crud-playlist');

require _namespace('layout.desktop-adm');