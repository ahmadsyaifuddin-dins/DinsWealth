<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewerController extends Controller
{
    public function index()
    {
        return view('viewer.dashboard'); // kita bikin view ini juga nanti
    }
}
