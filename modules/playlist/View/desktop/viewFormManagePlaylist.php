<?php

$namespace = 'playlist.viewFormManagePlaylist';
$mainContent = _namespace('playlist.layoutFormManagePlaylist');

push($namespace);

echo asset('js/text-box.js');
echo asset('js/upload/file-manager.js');
echo asset('js/playlist/form-manage-playlist.js');

endpush();

require _namespace('layout.desktop-adm');