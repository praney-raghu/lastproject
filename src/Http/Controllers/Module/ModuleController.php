<?php

namespace Ssntpl\Neev\Http\Controllers\Module;

use Illuminate\Http\Request;
use Ssntpl\Neev\Http\Controllers\Controller;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = \Module::all();
        return view('neev::admin.module.index')->with('modules',$modules);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $moduleName
     * @return \Illuminate\Http\Response
     */
    public function update($moduleName)
    {
        $module = \Module::find($moduleName);
        // Check if module is already enabled or not
        if($module->enabled())
            $module->disable();
        else
            $module->enable();

        return redirect(route('admin.modules.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $moduleName
     * @return \Illuminate\Http\Response
     */
    public function destroy($moduleName)
    {
        $module = \Module::find($moduleName);
        $module->disable();
        //$module->delete();

        return redirect(route('admin.modules.index'));
    }
}
