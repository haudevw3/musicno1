<?php

$_namespace = 'album.viewManageAlbum';

push($_namespace);

echo asset('js/table.js');
echo asset('js/album/table-manage-album.js');

endpush();

$components = [
    _namespace('components.adm.modal-dialog'),
    _namespace('album.components.table-manage-album'),
];

require _namespace('layout.desktop-adm');