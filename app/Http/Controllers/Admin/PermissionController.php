<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::latest('id');


        if (request('section')) {
            $permissions = $permissions->where('section', 'like', '%' . request('section') . '%');
        }

        if (request('permission')) {
            $permissions = $permissions->where('permission', 'like', '%' . request('permission') . '%');
        }


        $permissions = $permissions->whereNull('deleted_at')
            ->paginate(15);
        return view('dashboard.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required',
            'permission' => 'required',
        ]);

        $permission = new Permission();
        $permission->section = Str::slug($request->section);
        $permission->permission = Str::slug($request->permission);
        $permission->save();

        return redirect()->route('permissions.index')->with('success', 'Operation Done.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('dashboard.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'section' => 'required',
            'permission' => 'required',
        ]);

        $permission = Permission::find($id);
        $permission->section = Str::slug($request->section);
        $permission->permission = Str::slug($request->permission);
        $permission->save();

        return redirect()->route('permissions.index')->with('success', 'Operation Done.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Operation Done.');
    }


    // return the trash Permissions
    public function trashed()
    {
        $permissions = Permission::onlyTrashed()->orderby('id', 'desc')->paginate(15);
        return view('dashboard.permission.trashed', compact('permissions'));
    }

    // restore back the Permission
    public function restore($id)
    {
        Permission::withTrashed()->find($id)->restore();
        return redirect()->route('permissions.index')->with('success', 'Operation Done.');
    }
}
