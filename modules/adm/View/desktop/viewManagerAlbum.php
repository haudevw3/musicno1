<?php

push('adm.viewManagerAlbum');

echo asset('adm/js/album/album-manager.js');

endpush();

$_namespace = 'adm.viewManagerAlbum';

$component = _namespace('adm.components.table-list-album');

require _namespace('layout.desktop-adm');