<?php

namespace Ssntpl\Neev\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Ssntpl\Neev\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePermissionsRequest;
use App\Http\Requests\Admin\UpdatePermissionsRequest;

class PermissionsController extends Controller
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
     * Display a listing of Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('manage_permissions')) {
            return abort(401);
        }

        $permissions = Permission::all();

        return view('neev::admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating new Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('manage_permissions')) {
            return abort(401);
        }
        return view('neev::admin.permissions.create');
    }

    /**
     * Store a newly created Permission in storage.
     *
     * @param  \App\Http\Requests\StorePermissionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionsRequest $request)
    {
        if (!Gate::allows('manage_permissions')) {
            return abort(401);
        }
        Permission::create($request->all());

        return redirect()->route('admin.permissions.index');
    }

    /**
     * Show the form for editing Permission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('manage_permissions')) {
            return abort(401);
        }
        $permission = Permission::findOrFail($id);

        return view('neev::admin.permissions.edit', compact('permission'));
    }

    /**
     * Update Permission in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionsRequest $request, $id)
    {
        if (!Gate::allows('manage_permissions')) {
            return abort(401);
        }
        $permission = Permission::findOrFail($id);
        $permission->update($request->all());

        return redirect()->route('admin.permissions.index');
    }

    /**
     * Remove Permission from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('manage_permissions')) {
            return abort(401);
        }
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('admin.permissions.index');
    }

    /**
     * Delete all selected Permission at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('manage_permissions')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Permission::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}
