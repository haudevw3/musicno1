<?php

push('adm.viewCrudPlaylist');

echo asset('adm/js/convert-slug.js');

endpush();

$_namespace = 'adm.viewCrudPlaylist';

$component = _namespace('adm.components.form-crud-playlist');

require _namespace('layout.desktop-adm');