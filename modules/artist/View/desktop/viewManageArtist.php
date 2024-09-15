<?php

$namespace = 'artist.viewManageArtist';
$mainContent = _namespace('artist.layoutManageArtist');

push($namespace);

echo asset('js/table.js');
echo asset('js/artist/table-manage-artist.js');

endpush();

require _namespace('layout.desktop-adm');