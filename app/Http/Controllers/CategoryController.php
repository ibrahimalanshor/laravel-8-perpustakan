<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatable();
        }
        return view('category.index');
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
            'name' => 'required|string|max:255|unique:categories'
        ]);

        Category::create($request->all());

        return response()->json(['msg' => 'Success Create Category']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:books,name,'.$category->id
        ]);

        $category->update($request->all());

        return response()->json(['msg' => 'Success Update category']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['msg' => 'Success Delete category']);
    }

    // Get Categories
    public function get(Request $request)
    {
        $name = $request->name;
        $categories = Category::where('name', 'like', '%'.$name.'%')->latest()->get(['id', 'name as text']);
        return $categories;
    }

    // Get Datatable
    public function datatable()
    {
        $categories = Category::all();

        return Datatables::of($categories)
            ->addIndexColumn()
            ->addColumn('action', function ()
            {
                $btn = '
                    <button class="btn btn-success btn-sm edit">Edit</button>
                    <button class="btn btn-danger btn-sm delete">Delete</button>
                ';
                return $btn;
            })
            ->make(true);
    }
}
