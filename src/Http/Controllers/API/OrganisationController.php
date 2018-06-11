<?php

namespace Ssntpl\Neev\Http\Controllers\API;

use Illuminate\Http\Request;
use Ssntpl\Neev\Models\Organisation;
use Ssntpl\Neev\Http\Controllers\Controller;
use Ssntpl\Neev\Exceptions\UserNotInOrganisationException;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['success' => auth()->user() ], 200);
    }
}
