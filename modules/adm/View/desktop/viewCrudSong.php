<?php

push('adm.viewCrudSong');

echo asset('adm/js/convert-slug.js');

endpush();

$_namespace = 'adm.viewCrudSong';

$component = _namespace('adm.components.form-crud-song');

require _namespace('layout.desktop-adm');