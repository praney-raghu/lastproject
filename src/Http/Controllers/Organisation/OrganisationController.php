<?php

namespace Ssntpl\Neev\Http\Controllers\Organisation;

use Illuminate\Http\Request;
use Ssntpl\Neev\Models\Organisation;
use Ssntpl\Neev\Http\Controllers\Controller;
use Ssntpl\Neev\Exceptions\UserNotInOrganisationException;

class OrganisationController extends Controller
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
        return view('neev::user.organisation.index')
            ->with('organisations', auth()->user()->organisations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('neev::user.organisation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organisation = Organisation::create([
            'name' => $request->name,
            'owner_id' => $request->user()->owner_id,
            'code' => Organisation::suggestCode(substr($request->name, 0, 4))
        ]);
        $request->user()->attachOrganisation($organisation);
        $request->user()->assignRoleInOrganisation($organisation, 'admin');

        return redirect(route('organisation.index'));
    }

    /**
     * Switch to the given team.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function switchOrganisation(Organisation $organisation)
    {
        try {
            auth()->user()->switchOrganisation($organisation);
        } catch (UserNotInOrganisationException $e) {
            abort(403);
        }

       return redirect(route('organisation.index'));
    }

    /**
     * Switch to the given team in top bar while remaining on same page.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function switchOrganisationSameView(Organisation $organisation)
    {
        try {
            auth()->user()->switchOrganisation($organisation);
        } catch (UserNotInOrganisationException $e) {
            abort(403);
        }

        return redirect()->back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Organisation $organisation)
    {
        if (!auth()->user()->isAdmin($organisation)) {
            abort(403);
        }

        return view('neev::user.organisation.edit')->with('organisation', $organisation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organisation $organisation)
    {
        if (!auth()->user()->isAdmin($organisation)) {
            abort(403);
        }

        $organisation->name = $request->name;
        $organisation->save();

        return redirect(route('organisation.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organisation $organisation)
    {
        if (!auth()->user()->isAdmin($organisation)) {
            abort(403);
        }

        $organisation->delete();

        return redirect(route('organisation.index'));
    }
}
