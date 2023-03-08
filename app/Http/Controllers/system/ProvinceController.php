<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use DB;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Province::class);
        $provinces = Province::latest();

        if (request('name')) {
            $provinces = $provinces->where('name', 'like', '%' . request('name') . '%');
        }

        $provinces = $provinces->get();
        return view('dashboard.branches.provinces.index', compact('provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Province::class);
        return view('dashboard.branches.provinces.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Province::class);
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Province Name is required'
        ]);

        $province = new Province();
        $province->name = $request->name;
        $province->save();
        return redirect()->route('province.index')->with('success', 'Operation Done');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Province::class);
        $province = Province::find($id);
        return view('dashboard.branches.provinces.show', compact('province'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Province::class);
        $province = Province::find($id);
        return view('dashboard.branches.provinces.edit', compact('province'));
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
        $this->authorize('update', Province::class);
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Province Name is required'
        ]);

        $province = Province::find($id);
        $province->name = $request->name;
        $province->save();
        return redirect()->route('province.index')->with('success', 'Operation Done');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province)
    {
        $this->authorize('delete', Province::class);
        try {
            DB::beginTransaction();

            $province->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->back()->with('success', 'Operation Done.');
    }

    /**
     * Return the trashed provinces
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */

    public function trashed()
    {
        $this->authorize('restore', Province::class);
        $provinces = Province::onlyTrashed()->orderby('id', 'desc')->paginate(15);
        return view('dashboard.branches.provinces.trashed', compact('provinces'));
    }


    // restore back the customers from trash
    public function restore($id)
    {
        $this->authorize('restore', Province::class);
        try {
            DB::beginTransaction();

            Province::withTrashed()->find($id)->restore();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('province.index')->with('success', 'Operation Done.');
    }
}
