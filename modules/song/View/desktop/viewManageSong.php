<?php

$_namespace = 'song.viewManageSong';

push($_namespace);

echo asset('js/table.js');
echo asset('js/song/table-manage-song.js');

endpush();

$components = [
    _namespace('components.adm.modal-dialog'),
    _namespace('song.components.table-manage-song'),
];

require _namespace('layout.desktop-adm');