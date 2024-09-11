<?php

$_namespace = 'artist.viewManageArtist';

push($_namespace);

echo asset('js/table.js');
echo asset('js/artist/table-manage-artist.js');

endpush();

$components = [
    _namespace('components.adm.modal-dialog'),
    _namespace('artist.components.table-manage-artist'),
];

require _namespace('layout.desktop-adm');