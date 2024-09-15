<?php

$namespace = 'album.viewFormManageAlbum';
$mainContent = _namespace('album.layoutFormManageAlbum');

push($namespace);

echo asset('js/text-box.js');
echo asset('js/upload/file-manager.js');
echo asset('js/album/form-manage-album.js');
echo asset('js/song/form-manage-song.js');

endpush();

require _namespace('layout.desktop-adm');