<?php

$namespace = 'playlist.viewManagePlaylist';
$mainContent = _namespace('playlist.layoutManagePlaylist');

push($namespace);

echo asset('js/table.js');
echo asset('js/playlist/table-manage-playlist.js');

endpush();

require _namespace('layout.desktop-adm');