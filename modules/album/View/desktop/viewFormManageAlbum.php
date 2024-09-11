<?php

$_namespace = 'album.viewFormManageAlbum';

push($_namespace);

echo asset('js/text-box.js');
echo asset('js/upload/file-manager.js');
echo asset('js/album/form-manage-album.js');
echo asset('js/song/form-manage-song.js');

endpush();

$components = [
    _namespace('components.adm.loading'),
    _namespace('components.adm.file-manager'),
    _namespace('album.components.form-manage-album'),
];

require _namespace('layout.desktop-adm');