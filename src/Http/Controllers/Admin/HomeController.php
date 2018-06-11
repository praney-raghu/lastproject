<?php

namespace Ssntpl\Neev\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Ssntpl\Neev\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('neev::admin.home');
    }
}
