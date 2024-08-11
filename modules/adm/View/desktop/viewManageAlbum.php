<?php

$_namespace = 'adm.viewManageAlbum';

push($_namespace);

echo asset('adm/js/album/album-manage.js');

endpush();

$component = _namespace('adm.components.table-manage-album');

require _namespace('layout.desktop-adm');