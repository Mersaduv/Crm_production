<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Category;

class PackageController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Package::class);
        $packages = Package::latest();

        if (request('id')) {
            $packages = $packages->where('category_id', '=', request('id'));
        }

        if (request('name')) {
            $packages = $packages->where('name', 'like', '%' . request('name') . '%');
        }

        if (request('price')) {
            $packages = $packages->where('price', '=', request('price'));
        }

        if (request('duration')) {
            $packages = $packages->where('duration', '=', request('duration'));
        }

        $categories = Category::all();
        $packages = $packages->paginate(15);
        return view('dashboard.packages.index', compact(['packages', 'categories']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Package::class);
        $categories = Category::all();
        return view('dashboard.packages.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Package::class);
        $request->validate([
            'category' => 'required',
            'name' => 'required',
            'speed' => 'required',
        ], [
            'name.required' => 'Package Name is required',
            'speed.required' => 'Package Speed is required',
            'category.required' => 'Package Category is required',
        ]);

        $package = new Package();
        $package->category_id = $request->category;
        $package->name = $request->name;
        $package->speed = $request->speed;
        $package->price_currency = $request->price_currency;
        $package->price = $request->price;
        $package->data_type = $request->data_type;
        $package->data = $request->data;
        $package->duration = $request->duration;
        $package->duration_unit = $request->duration_unit;
        $package->daily_limit = $request->daily_limit;
        $package->active_hrs = $request->active_hrs;
        $package->free_usage = $request->free_usage;
        $package->save();

        return redirect()->route('packages.index')->with('success', 'Operation Done.');
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
        $this->authorize('update', Package::class);
        $categories = Category::all();
        $package = Package::find($id);
        return view('dashboard.packages.edit', compact(['package', 'categories']));
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
        $this->authorize('update', Package::class);
        $request->validate([
            'category' => 'required',
            'name' => 'required',
            'speed' => 'required',
        ], [
            'name.required' => 'Package Name is required',
            'speed.required' => 'Package Speed is required',
            'category.required' => 'Package Category is required',
        ]);

        $package = Package::find($id);
        $package->category_id = $request->category;
        $package->name = $request->name;
        $package->speed = $request->speed;
        $package->price = $request->price;
        $package->price_currency = $request->price_currency;
        $package->data_type = $request->data_type;
        $package->data = $request->data;
        $package->duration = $request->duration;
        $package->duration_unit = $request->duration_unit;
        $package->daily_limit = $request->daily_limit;
        $package->active_hrs = $request->active_hrs;
        $package->free_usage = $request->free_usage;
        $package->save();

        return redirect()->route('packages.index')->with('success', 'Operation Done.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Package::class);
        $package = Package::find($id);
        $package->delete();
        return redirect()->route('packages.index')->with('success', 'Operation Done.');
    }

    /**
     * Restore the trashed items
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $this->authorize('restore', Package::class);
        Package::withTrashed()->find($id)->restore();
        return redirect()->route('packages.index')->with('success', 'Operation Done.');
    }

    /**
     * Return the trashed items
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function trashed()
    {
        $this->authorize('restore', Package::class);
        $packages = Package::onlyTrashed()->orderby('id', 'desc')->paginate(15);
        return view('dashboard.packages.trashed', compact('packages'));
    }
}
