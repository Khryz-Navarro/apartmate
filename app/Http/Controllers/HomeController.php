<?php

namespace App\Http\Controllers;

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
