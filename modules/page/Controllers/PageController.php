<?php

namespace Modules\Page\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function home(Request $request)
    {   
        return view('layout.desktop-frontend');
    }
}
