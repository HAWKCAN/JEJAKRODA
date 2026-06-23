<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('user.pages.about');
    }

    public function contact()
    {
        return view('user.pages.contact');
    }

    public function sop()
    {
        return view('user.pages.sop');
    }
}