<?php

push('adm.viewManagerArtist');

echo asset('adm/js/artist/artist-manager.js');

endpush();

$_namespace = 'adm.viewManagerArtist';

$component = _namespace('adm.components.table-list-artist');

require _namespace('layout.desktop-adm');