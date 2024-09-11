<?php

$_namespace = 'playlist.viewFormManagePlaylist';

push($_namespace);

echo asset('js/text-box.js');
echo asset('js/upload/file-manager.js');
echo asset('js/playlist/form-manage-playlist.js');

endpush();

$components = [
    _namespace('components.adm.file-manager'),
    _namespace('playlist.components.form-manage-playlist'),
];

require _namespace('layout.desktop-adm');