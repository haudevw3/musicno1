<?php

$_namespace = 'adm.viewManageSong';

push($_namespace);

echo asset('adm/js/song/song-manage.js');

endpush();

$component = _namespace('adm.components.table-manage-song');

require _namespace('layout.desktop-adm');