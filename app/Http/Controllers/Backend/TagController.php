<?php

namespace App\Http\Controllers\Backend;

use App\Models\Tag;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('tags.view')) {
            abort(403);
        }
        
        return Inertia::render('Backend/Pages/Blog/Tags', [
            'tagsData' => Tag::orderBy('id', 'desc')->get(),
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
        if (!Auth::user()->hasPermission('tags.create')) {
            abort(403);
        }

        if ($request->id && !Auth::user()->hasPermission('tags.update')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|unique:tags|max:20',
        ]);

        Tag::updateOrCreate(
            [
                'id' => $request->id
            ], 
            [
                'name' => $request->name,
                'slug' => $request->name
            ]
        );

        return redirect()->back()->with('success', 'Tag saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        if (!Auth::user()->hasPermission('tags.delete')) {
            abort(403);
        }

        $tag->delete();

        return redirect()->back()->with('success', 'Tag deleted successfully!');
    }
}
