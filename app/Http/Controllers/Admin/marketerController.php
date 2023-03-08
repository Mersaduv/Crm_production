<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marketer;
use Illuminate\Http\Request;
use \Exception;
use DB;
use Auth;

class marketerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Marketer::class);
        $marketers = Marketer::latest('marketers.id');

        if (request('phone')) {
            $marketers = $marketers->where('phone', 'like', '%' . request('phone') . '%');
        }

        if (request('name')) {
            $marketers = $marketers->where('name', 'like', '%' . request('name') . '%');
        }

        $marketers = $marketers->whereNull('deleted_at')
            ->paginate(15);

        return view('dashboard.marketers.index', compact('marketers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Marketer::class);
        return view('dashboard.marketers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Marketer::class);
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => 'required',
                'phone' => 'required'
            ], [
                'name.required' => 'Name is required',
                'phone.required' => 'Phone Number is required',
            ]);

            $marketer = new Marketer();
            $marketer->name = $request->name;
            $marketer->phone = $request->phone;
            $marketer->user_id = Auth::user()->id;
            $marketer->save();

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
     * @param  \App\Models\Marketer  $marketer
     * @return \Illuminate\Http\Response
     */
    public function show(Marketer $marketer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marketer  $marketer
     * @return \Illuminate\Http\Response
     */
    public function edit(Marketer $marketer)
    {
        $this->authorize('update', Marketer::class);
        return view('dashboard.marketers.edit', compact('marketer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marketer  $marketer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marketer $marketer)
    {
        $this->authorize('update', Marketer::class);
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => 'required',
                'phone' => 'required'
            ], [
                'name.required' => 'Name is required',
                'phone.required' => 'Phone Number is required',
            ]);

            $marketer->name = $request->name;
            $marketer->phone = $request->phone;
            $marketer->user_id = Auth::user()->id;
            $marketer->save();

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
     * @param  \App\Models\Marketer  $marketer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marketer $marketer)
    {
        $this->authorize('delete', Marketer::class);
        try {
            DB::beginTransaction();

            $marketer->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->back()->with('success', 'Operation Done.');
    }

    /**
     * Return the trashed marketers
     *
     * @param  \App\Models\Marketer  $marketer
     * @return \Illuminate\Http\Response
     */

    public function trashed()
    {
        $this->authorize('restore', Marketer::class);
        $marketers = Marketer::onlyTrashed()->orderby('id', 'desc')->paginate(15);
        return view('dashboard.marketers.trash', compact('marketers'));
    }

    // restore back the customers from trash
    public function restore($id)
    {
        $this->authorize('restore', Marketer::class);
        try {
            DB::beginTransaction();

            Marketer::withTrashed()->find($id)->restore();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('marketers.index')->with('success', 'Operation Done.');
    }
}
