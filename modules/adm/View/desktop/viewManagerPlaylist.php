<?php

push('adm.viewManagerPlaylist');

echo asset('adm/js/playlist/playlist-manager.js');

endpush();

$_namespace = 'adm.viewManagerPlaylist';

$component = _namespace('adm.components.table-list-playlist');

require _namespace('layout.desktop-adm');