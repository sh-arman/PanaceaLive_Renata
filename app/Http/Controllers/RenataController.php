<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RenataController extends Controller
{
    public function home()
    {
        # code...
        return view('renata.home');
    }
}
