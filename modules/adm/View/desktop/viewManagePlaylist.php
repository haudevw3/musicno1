<?php

$_namespace = 'adm.viewManagePlaylist';

push($_namespace);

echo asset('adm/js/playlist/playlist-manage.js');

endpush();

$component = _namespace('adm.components.table-manage-playlist');

require _namespace('layout.desktop-adm');