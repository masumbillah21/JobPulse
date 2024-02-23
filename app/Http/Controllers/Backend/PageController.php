<?php

namespace App\Http\Controllers\Backend;

use App\Models\Page;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $pages = Page::paginate(10);
        return Inertia::render('Backend/Pages/Index', [
            'pageList' => $pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Backend/Pages/Edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:pages',
            'contents' => 'nullable|array',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'contents.*.data.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'page_type' => 'required|string',
            'for_nav' => 'required|boolean',
            'email_to' => 'nullable|email|lowercase|max:50',
            'page_order' => 'required|integer',
            'status' => 'required|boolean',
        ]);


        

        $contents = [];
        if ($request->has('contents')) {
            $contents = $request->contents;
            foreach ($contents as &$content) {
                foreach ($content['data'] as &$item) {
                    if (isset($item['image'])) {
                        $image = $item['image'];
                        $imageName = 'images/'.time() . '_' . $image->getClientOriginalName();
                        $image->storeAs('public', $imageName);
                        $item['image'] = config('app.url') . Storage::url($imageName);
                    }
                }
            }
        }

        $image_path = '';
        if ($request->hasFile('featured_image')) {
            $image_path = $request->file('featured_image')->store('images', 'public');
        }

        Page::create([
            'title' => $request->title,
            'user_id' => auth()->user()->id,
            'featured_image' => $image_path,
            'contents' => $contents,
            'page_type' => $request->page_type,
            'for_nav' => $request->for_nav,
            'email_to' => $request->email_to,
            'page_order' => $request->page_order,
            'status' => $request->status,
            'slug' => $request->title,
        ]);

        return redirect()->back()->with('success', 'Page created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return Inertia::render('Backend/Pages/Edit', [
            'pageData' => $page
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }
}
