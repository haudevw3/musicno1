<?php

$_namespace = 'adm.viewCrudSong';

push($_namespace);

echo asset('adm/js/convert-slug.js');

endpush();

$component = _namespace('adm.components.form-crud-song');

require _namespace('layout.desktop-adm');