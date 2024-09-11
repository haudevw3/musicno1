<?php

$_namespace = 'artist.viewFormManageArtist';

push($_namespace);

echo asset('js/artist/form-manage-artist.js');
echo asset('js/upload/file-manager.js');

endpush();

$components = [
    _namespace('components.adm.file-manager'),
    _namespace('artist.components.form-manage-artist'),
];

require _namespace('layout.desktop-adm');