<?php

$_namespace = 'song.viewFormManageSong';

push($_namespace);

echo asset('js/text-box.js');
echo asset('js/upload/file-manager.js');
echo asset('js/song/form-manage-song.js');

endpush();

$components = [
    _namespace('components.adm.file-manager'),
    _namespace('song.components.form-manage-song'),
];

require _namespace('layout.desktop-adm');