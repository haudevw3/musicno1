<?php

$namespace = 'artist.viewFormManageArtist';
$mainContent = _namespace('artist.layoutFormManageArtist');

push($namespace);

echo asset('js/upload/file-manager.js');
echo asset('js/artist/form-manage-artist.js');

endpush();

require _namespace('layout.desktop-adm');