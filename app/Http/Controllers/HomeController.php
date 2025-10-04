<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the landing page
     */
    public function index()
    {
        return view('home');
    }
}
