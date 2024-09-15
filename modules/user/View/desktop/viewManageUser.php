<?php

$namespace = 'user.viewManageUser';
$mainContent = _namespace('user.layoutManageUser');

push($namespace);

echo asset('js/table.js');
echo asset('js/user/table-manage-user.js');

endpush();

require _namespace('layout.desktop-adm');