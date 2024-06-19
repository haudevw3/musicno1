<?php

push('adm.viewManagerUser');

echo asset('adm/js/user/user-manager.js');

endpush();

$_namespace = 'adm.viewManagerUser';

$component = _namespace('adm.components.table-list-user');

require _namespace('layout.desktop-adm');