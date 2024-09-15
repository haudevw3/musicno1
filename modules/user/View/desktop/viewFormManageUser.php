<?php

$namespace = 'user.viewFormManageUser';
$mainContent = _namespace('user.layoutFormManageUser');

push($namespace);

echo asset('js/upload/file-manager.js');
echo asset('js/user/form-manage-user.js');

endpush();

require _namespace('layout.desktop-adm');