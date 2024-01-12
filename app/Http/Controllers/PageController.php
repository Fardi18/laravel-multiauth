<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function user()
    {
        return view("user.welcome");
    }

    public function admin()
    {
        return view("admin.index");
    }

    public function pka()
    {
        return view("pka.index");
    }
}
