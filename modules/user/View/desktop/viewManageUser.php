<?php

$_namespace = 'user.viewManageUser';

push($_namespace);

echo asset('js/table.js');
echo asset('js/user/table-manage-user.js');

endpush();

$components = [
    _namespace('components.adm.modal-dialog'),
    _namespace('user.components.table-manage-user'),
];

require _namespace('layout.desktop-adm');