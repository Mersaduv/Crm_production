<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class PackageCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Category::class);
        $categories = Category::latest();

        if (request('name')) {
            $categories = $categories->where('name', 'like', '%' . request('name') . '%');
        }

        $categories = $categories->paginate(15);
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Category::class);
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Category Name is required',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Operation Done.');
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
        $this->authorize('update', Category::class);
        $category = Category::find($id);
        return view('dashboard.categories.edit', compact('category'));
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
        $this->authorize('update', Category::class);
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Category Name is required',
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Operation Done.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Category::class);
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Operation Done.');
    }

    /**
     * Restore the trashed items
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $this->authorize('restore', Category::class);
        Category::withTrashed()->find($id)->restore();
        return redirect()->route('categories.index')->with('success', 'Operation Done.');
    }

    /**
     * Return the trashed items
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function trashed()
    {
        $this->authorize('restore', Category::class);
        $categories = Category::onlyTrashed()->orderby('id', 'desc')->paginate(15);
        return view('dashboard.categories.trashed', compact('categories'));
    }
}
