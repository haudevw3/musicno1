<?php

push('adm.viewManagerSong');

echo asset('adm/js/song/song-manager.js');

endpush();

$_namespace = 'adm.viewManagerSong';

$component = _namespace('adm.components.table-list-song');

require _namespace('layout.desktop-adm');