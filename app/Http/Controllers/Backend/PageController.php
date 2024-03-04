<?php

namespace App\Http\Controllers\Backend;

use App\Models\Page;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Page::class);
        
        $pages = Page::get();
        return Inertia::render('Backend/Pages/Index', [
            'pageList' => $pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Page::class);

        return Inertia::render('Backend/Pages/Edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Page::class);

        $request->validate([
            'title' => 'required|string|max:255|unique:pages',
            'contents' => 'nullable|array',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'contents.*.data.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
                    if (isset($item['image']) && $item['image'] instanceof UploadedFile) {
                        $fileContents = file_get_contents($item['image']->path());
                        $base64Image = base64_encode($fileContents);
                        $item['image'] = $base64Image;
                    }
                }
            }
        }

        $image_path = '';
        if ($request->hasFile('featured_image')) {
            $image_path = $request->file('featured_image')->store('images', 'public');
       }

        $page =  Page::create([
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

        return redirect()->route('admin.pages.edit', $page->id)->with('success', 'Page created successfully');
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
        $this->authorize('update', Page::class);

        return Inertia::render('Backend/Pages/Edit', [
            'pageData' => $page
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $this->authorize('update', Page::class);

        $request->validate([
            'title' => 'required|string|max:255|' . Rule::unique(Page::class)->ignore($request->id),
            'contents' => 'nullable|array',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
                    if (isset($item['image']) && $item['image'] instanceof UploadedFile) {
                        $fileContents = file_get_contents($item['image']->path());
                        $base64Image = base64_encode($fileContents);
                        $item['image'] = $base64Image;
                    }
                }
            }
        }

        $dataToUpdate = [
            'title' => $request->title,
            'user_id' => auth()->user()->id,
            'contents' => $contents,
            'page_type' => $request->page_type,
            'for_nav' => $request->for_nav,
            'email_to' => $request->email_to,
            'page_order' => $request->page_order,
            'status' => $request->status,
            'slug' => $request->title,
        ];

        if ($request->hasFile('featured_image')) {
            $image_path = $request->file('featured_image')->store('images', 'public');
            $dataToUpdate['featured_image'] = $image_path;

            Storage::disk('public')->delete($page->featured_image);
        }

        $page->update($dataToUpdate);

        return redirect()->back()->with('success', 'Page updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $this->authorize('delete', Page::class);

        $page->delete();
        return redirect()->back()->with('success', 'Page deleted successfully');
    }
}
