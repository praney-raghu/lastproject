<?php

namespace Ssntpl\Neev\Http\Controllers\API;

use Illuminate\Http\Request;
use Ssntpl\Neev\Http\Controllers\Controller;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('neev::admin.token.index');
    }
}
