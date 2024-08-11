<?php

$_namespace = 'adm.viewManageUser';

push($_namespace);

echo asset('adm/js/user/user-manage.js');

endpush();

$component = _namespace('adm.components.table-manage-user');

require _namespace('layout.desktop-adm');