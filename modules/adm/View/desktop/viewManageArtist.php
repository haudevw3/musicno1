<?php

$_namespace = 'adm.viewManageArtist';

push($_namespace);

echo asset('adm/js/artist/artist-manage.js');

endpush();

$component = _namespace('adm.components.table-manage-artist');

require _namespace('layout.desktop-adm');