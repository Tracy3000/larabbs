<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function root()
    {
        echo 1;
        return view('pages.root');
    }
}
