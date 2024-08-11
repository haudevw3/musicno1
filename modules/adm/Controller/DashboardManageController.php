<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;

class DashboardManageController
{
    public function pageManageDashboard(Request $request)
    {
        return view('adm.viewManageDashboard');
    }
}