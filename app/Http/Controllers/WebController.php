<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function welcom(Request $request)
    {
        return view('welcome');
    }

    public function contact(Request $request)
    {
        return view('contact');
    }

    public function avancement(Request $request)
    {
        return view('avancement');
    }
}
