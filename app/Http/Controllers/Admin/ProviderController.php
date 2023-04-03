<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use \Exception;
use DB;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Provider::class);
        $providers = Provider::latest('providers.id');

        if (request('name')) {
            $providers = $providers->where('name', 'like', '%' . request('name') . '%');
        }

        $providers = $providers->whereNull('deleted_at')
            ->paginate(15);

        return view('dashboard.providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Provider::class);
        return view('dashboard.providers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Provider::class);
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => 'required',
            ], [
                'name.required' => 'Name is required',
            ]);

            $provider = new Provider();
            $provider->name = $request->name;
            $provider->user_id = Auth::user()->id;
            $provider->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('providers.index')->with('success', 'Operation Done!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Provider $provider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $provider)
    {
        $this->authorize('update', Provider::class);
        return view('dashboard.providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provider $provider)
    {
        $this->authorize('update', Provider::class);
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => 'required',
            ], [
                'name.required' => 'Name is required',
            ]);

            $provider->name = $request->name;
            $provider->user_id = Auth::user()->id;
            $provider->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('providers.index')->with('success', 'Operation Done!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        $this->authorize('delete', Provider::class);
        try {
            DB::beginTransaction();

            $provider->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->back()->with('success', 'Operation Done.');
    }

    /**
     * Return the trashed providers
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */

    public function trashed()
    {
        $this->authorize('restore', Provider::class);
        $providers = Provider::onlyTrashed()->orderby('id', 'desc')->paginate(15);
        return view('dashboard.providers.trash', compact('providers'));
    }

    // restore back the customers from trash
    public function restore($id)
    {
        $this->authorize('restore', Provider::class);
        try {
            DB::beginTransaction();

            Provider::withTrashed()->find($id)->restore();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('providers.index')->with('success', 'Operation Done.');
    }
}
