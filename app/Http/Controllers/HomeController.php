<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application home (redirect to dashboard).
     */
    public function index(Request $request)
    {
        return redirect()->route('dashboard');
    }
}
