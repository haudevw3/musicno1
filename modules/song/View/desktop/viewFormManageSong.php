<?php

$namespace = 'song.viewFormManageSong';
$mainContent = _namespace('song.layoutFormManageSong');

push($namespace);

echo asset('js/text-box.js');
echo asset('js/upload/file-manager.js');
echo asset('js/song/form-manage-song.js');

endpush();

require _namespace('layout.desktop-adm');