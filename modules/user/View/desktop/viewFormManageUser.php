<?php

$_namespace = 'user.viewFormManageUser';

push($_namespace);

echo asset('js/user/form-manage-user.js');
echo asset('js/upload/file-manager.js');

endpush();

$components = [
    _namespace('user.components.form-manage-user'),
    _namespace('components.adm.file-manager'),
];

require _namespace('layout.desktop-adm');