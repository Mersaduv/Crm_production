<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;
use \Exception;
use DB;
use Auth;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Commission::class);
        $commissions = Commission::latest('commissions.id');

        if (request('phone')) {
            $commissions = $commissions->where('phone', 'like', '%' . request('phone') . '%');
        }

        if (request('name')) {
            $commissions = $commissions->where('name', 'like', '%' . request('name') . '%');
        }

        $commissions = $commissions
            ->whereNull('deleted_at')
            ->paginate(15);

        return view('dashboard.commission.index', compact('commissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Commission::class);
        return view('dashboard.commission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Commission::class);
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => 'required',
                'phone' => 'required'
            ], [
                'name.required' => 'Name is required',
                'phone.required' => 'Phone Number is required',
            ]);

            $commission = new Commission();
            $commission->name = $request->name;
            $commission->phone = $request->phone;
            $commission->user_id = Auth::user()->id;
            $commission->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->back()->with('success', 'Operation Done!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function show(Commission $commission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function edit(Commission $commission)
    {
        $this->authorize('update', $commission);
        return view('dashboard.commission.edit', compact('commission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commission $commission)
    {
        $this->authorize('update', $commission);
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => 'required',
                'phone' => 'required'
            ], [
                'name.required' => 'Name is required',
                'phone.required' => 'Phone Number is required',
            ]);

            $commission->name = $request->name;
            $commission->phone = $request->phone;
            $commission->user_id = Auth::user()->id;
            $commission->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->back()->with('success', 'Operation Done!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commission $commission)
    {
        $this->authorize('delete', $commission);
        try {
            DB::beginTransaction();

            $commission->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->back()->with('success', 'Operation Done.');
    }

    /**
     * Return the trashed commissions
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */

    public function trashed()
    {
        $this->authorize('restore', Commission::class);
        $commissions = Commission::onlyTrashed()->orderby('id', 'desc')->paginate(15);
        return view('dashboard.commission.trashed', compact('commissions'));
    }

    // restore back the customers from trash
    public function restore($id)
    {
        $this->authorize('restore', Commission::class);
        try {
            DB::beginTransaction();

            Commission::withTrashed()->find($id)->restore();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('commission.index')->with('success', 'Operation Done.');
    }
}
