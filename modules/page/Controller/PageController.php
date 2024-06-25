<?php

namespace Modules\Page\Controller;

class PageController
{
    public function index()
    {
        return view('page.viewHome');
    }

    public function home()
    {
        return view('page.viewHome');
    }
}