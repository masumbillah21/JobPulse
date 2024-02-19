<?php

namespace App\Http\Controllers\Backend;

use Auth;
use Exception;
use App\Models\Blog;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::where('user_id', Auth::user()->id)->with('user')->paginate(10);
        return Inertia::render('Backend/Pages/Blog/Index', [
            'blogsData' => $blogs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Backend/Pages/Blog/Edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     
           
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $image_path = '';

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('images', 'public');
        }

        if(!isset($request->status)){
            $request->status = 0;
        }

        Blog::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'image' => $image_path,
            'slug' => $request->title,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Blog Created Successfully');

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return Inertia::render('Backend/Pages/Blog/Edit', [
            'blogData' => $blog
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        // try{
            $validation = $request->validate([
                'title' => 'required|max:255',
                'body' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:500',
                'status' => 'nullable|boolean',
                'slug' => 'nullable|max:255'
            ]);

            if ($request->hasFile('image')) {
                $image_path = $request->file('image')->store('images', 'public');
                Storage::disk('public')->delete($blog->image);
                
                $validation['image'] = $image_path;
            }else{
                unset($validation['image']);
            }

            $validation['slug'] = $request->title;

            $blog->update($validation);

            return redirect()->back()->with('success', 'Blog Updated Successfully');

        // }
        // catch (Exception $e){
        //     return redirect()->back()->withErrors('error', $e->getMessage());
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->back()->with('success', 'Blog Deleted Successfully');
    }
}
