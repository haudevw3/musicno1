<?php

$namespace = 'song.viewManageSong';
$mainContent = _namespace('song.layoutManageSong');

push($namespace);

echo asset('js/table.js');
echo asset('js/song/table-manage-song.js');

endpush();

require _namespace('layout.desktop-adm');