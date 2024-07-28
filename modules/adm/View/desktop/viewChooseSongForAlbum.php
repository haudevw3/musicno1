<?php

push('adm.viewChooseSongForAlbum');

echo asset('adm/js/checkbox.js');

endpush();

$_namespace = 'adm.viewChooseSongForAlbum';

$component = _namespace('adm.components.form-option-choose-song-for-album');

require _namespace('layout.desktop-adm');