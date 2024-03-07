<?php

namespace App\Http\Controllers\Backend;

use Exception;
use Inertia\Inertia;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('job.categories.view')) {
            abort(403);
        }
        $cateList = JobCategory::orderBy('id', 'desc')->get();

        return Inertia::render('Backend/Jobs/Categories', [
            'jobCateList' => $cateList
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
        if (!Auth::user()->hasPermission('job.categories.create')) {
            abort(403);
        }

        if($request->id && !Auth::user()->hasPermission('job.categories.update')) {
            abort(403);
        }

        try{
            
            $request->validate([
                'name' => 'required|unique:categories|max:20',
            ]);
            //New category
            if ($request->id == null || $request->id == 0) {
                $request->validate([
                    'logo' => 'required|image|mimes:jpeg,png,jpg|max:300',
                ]);
    
                if ($request->hasFile('logo')) {
                    $logo = $request->file('logo')->store('images', 'public');
                    $request->merge(['cate_logo' => $logo]);
                }
            }else{
                // Update Category
                $request->validate([
                    'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:500',
                ]);
    
                $oldImage = JobCategory::where('id', $request->id)->first();

                if ($request->hasFile('logo')) {
                    $image_path = $request->file('logo')->store('images', 'public');

                    if ($oldImage->logo != null) {
                        Storage::disk('public')->delete($oldImage->logo);
                    }
                    
                    $request->merge(['cate_logo' => $image_path]);
                }else{
                    $request->merge(['cate_logo' => '']);
                }
            }

            $data = [
                'name' => $request->name,
                'logo' => $request->cate_logo,
                'slug' => $request->name
            ];

            if(empty($data['logo'])){
                unset($data['logo']);
            }
    
            JobCategory::updateOrCreate(
                [
                    'id' => $request->id
                ],
                $data
            );
    
            return redirect()->back()->with('success', 'Category saved successfully!');
        }catch(Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(JobCategory $jobCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobCategory $jobCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobCategory $jobCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::user()->hasPermission('job.categories.delete')) {
            abort(403);
        }

        JobCategory::find($id)->delete();

        return redirect()->back()->with('success', 'Job Category deleted successfully!');
    }
}
