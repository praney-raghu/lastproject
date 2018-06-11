<?php

namespace Ssntpl\Neev\Http\Controllers\Organisation;

use Illuminate\Http\Request;
use Ssntpl\Neev\Models\Organisation;
use Ssntpl\Neev\Http\Controllers\Controller;
use Ssntpl\Neev\Exceptions\UserNotInOrganisationException;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('neev::company.index');
    }

    /**
     * Show the form for editing the specified resource.
     * 
    * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('neev::company.edit');
    }
}
