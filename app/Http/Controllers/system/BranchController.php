<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Province;
use DB;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Branch::class);
        $branches = Branch::latest();

        if (request('name')) {
            $branches = $branches->where('name', 'like', '%' . request('name') . '%');
        }

        if (request('province')) {
            $branches = $branches->where('province_id', '=', request('province'));
        }

        $branches = $branches->get();
        $provinces = Province::all();
        return view('dashboard.branches.branches.index', compact('branches', 'provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Branch::class);
        $provinces = Province::all();
        return view('dashboard.branches.branches.create', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Branch::class);
        $request->validate([
            'name'    => 'required',
            'address' => 'required',
            'province_id' => 'required'
        ], [
            'name.required' => 'Branch name is required',
            'address.required' => 'Branch Address is required',
            'province_id.required' => 'Branch Province is required'
        ]);

        $branch = new Branch();
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->province_id = $request->province_id;
        $branch->save();
        return redirect()->route('branch.index')->with('success', 'Operation Done');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Branch::class);
        $branch = Branch::find($id);
        return view('dashboard.branches.branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Branch::class);
        $branch = Branch::find($id);
        $provinces = Province::all();
        return view('dashboard.branches.branches.edit', compact('branch', 'provinces'));
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
        $this->authorize('update', Branch::class);
        $request->validate([
            'name'    => 'required',
            'address' => 'required',
            'province_id' => 'required'
        ], [
            'name.required' => 'Branch name is required',
            'address.required' => 'Branch Address is required',
            'province_id.required' => 'Branch Province is required'
        ]);

        $branch = Branch::find($id);
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->province_id = $request->province_id;
        $branch->save();
        return redirect()->route('branch.index')->with('success', 'Operation Done');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $this->authorize('delete', Branch::class);
        try {
            DB::beginTransaction();

            $branch->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->back()->with('success', 'Operation Done.');
    }

    /**
     * Return the trashed branches
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */

    public function trashed()
    {
        $this->authorize('restore', Branch::class);
        $branches = Branch::onlyTrashed()->orderby('id', 'desc')->paginate(15);
        return view('dashboard.branches.branches.trashed', compact('branches'));
    }

    public function restore($id)
    {
        $this->authorize('restore', Branch::class);
        try {
            DB::beginTransaction();

            Branch::withTrashed()->find($id)->restore();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('branch.index')->with('success', 'Operation Done.');
    }
}
