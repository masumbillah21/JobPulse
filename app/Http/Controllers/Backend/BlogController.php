<?php

namespace App\Http\Controllers\Backend;

use App\Enum\UserRoleEnum;
use Auth;
use Exception;
use App\Models\Tag;
use App\Models\Blog;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Blog::class);
       
        if(Auth()->user()->roles->pluck('name')->first() === UserRoleEnum::SUPER_ADMIN->value){
            $blogs = Blog::with('user')->get();
        }else{
            $blogs = Blog::where('user_id', Auth::user()->id)->with('user')->get();
        }
        
        $category = Category::all();
        return Inertia::render('Backend/Blog/Index', [
            'blogsData' => $blogs,
            'categoryData' => $category
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Blog::class); 

        $category = Category::pluck('name', 'id')->toArray();
        return Inertia::render('Backend/Blog/Edit',[
            'categoryData' => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $this->authorize('create', Blog::class); 
    
       DB::beginTransaction();
       try{
            $request->validate([
                'title' => 'required|max:255',
                'body' => 'required',
                'categories' => 'required|array',
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

            $blog = Blog::create([
                'user_id' => Auth::user()->id,
                'title' => $request->title,
                'body' => $request->body,
                'image' => $image_path,
                'slug' => $request->title,
                'status' => $request->status
            ]);

            $blog->categories()->attach($request->categories);
            $this->attachTagsToBlog($blog->id, $request->tags);

            DB::commit();
            return redirect()->back()->with('success', 'Blog Created Successfully');

       }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
       }
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $this->authorize('view', Blog::class);

        return Inertia::render('Backend/Blog/Show', [
            'blogData' => $blog
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog); 
        $category = Category::pluck('name', 'id')->toArray();
        $blogData = $blog->load('categories:id');
        $categoryIds = $blogData->categories->pluck('id')->toArray();

        $blogData['category_ids'] = $categoryIds;
        return Inertia::render('Backend/Blog/Edit', [
            'blogData' => $blogData,
            'categoryData' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $this->authorize('update', $blog); 

        DB::beginTransaction();
        try{
            $validation = $request->validate([
                'title' => 'required|max:255',
                'body' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:500',
                'status' => 'nullable|boolean',
                'categories' => 'required|array',
                'tags' => 'required|string',
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
            unset($validation['categories']);
            $blog->update($validation);

            $blog->categories()->sync($request->categories);
            $this->attachTagsToBlog($blog->id, $request->tags);

            DB::commit();
            return redirect()->back()->with('success', 'Blog Updated Successfully');

        }
        catch (Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog); 

        // $blog->delete();

        return redirect()->back()->with('success', 'Blog Deleted Successfully');
    }

    public function attachTagsToBlog($blogId, $tagNames)
    {
        $tagIds = [];

        $tagNames = explode(',', $tagNames);
        foreach ($tagNames as $tagName) {
            $tag = Tag::firstOrCreate(
                [
                    'name' => trim($tagName),
                ],
                [
                    'name' => trim($tagName),
                    'slug' => trim($tagName),
                ]
            );
            $tagIds[] = $tag->id;
        }
        Blog::find($blogId)->tags()->syncWithoutDetaching($tagIds);
    }
}
