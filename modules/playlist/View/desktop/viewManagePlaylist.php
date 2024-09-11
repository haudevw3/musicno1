<?php

$_namespace = 'playlist.viewManagePlaylist';

push($_namespace);

echo asset('js/table.js');
echo asset('js/playlist/table-manage-playlist.js');

endpush();

$components = [
    _namespace('components.adm.modal-dialog'),
    _namespace('playlist.components.table-manage-playlist'),
];

require _namespace('layout.desktop-adm');