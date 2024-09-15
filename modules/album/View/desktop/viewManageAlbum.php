<?php

$namespace = 'album.viewManageAlbum';
$mainContent = _namespace('album.layoutManageAlbum');

push($namespace);

echo asset('js/table.js');
echo asset('js/album/table-manage-album.js');

endpush();

require _namespace('layout.desktop-adm');