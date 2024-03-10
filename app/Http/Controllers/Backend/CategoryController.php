<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('categories.view')) {
            abort(403);
        }
        
        return Inertia::render('Backend/Blog/Categories', [
            'categoriesData' => Category::orderBy('id', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('categories.create')) {
            abort(403);
        }

        if($request->id && !Auth::user()->hasPermission('categories.update')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|unique:categories|max:30',
        ]);

        Category::updateOrCreate(
            [
                'id' => $request->id
            ], 
            [
                'name' => $request->name,
                'slug' => $request->name
            ]
        );

        return redirect()->back()->with('success', 'Category saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (!Auth::user()->hasPermission('categories.delete')) {
            abort(403);
        }

        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
}
