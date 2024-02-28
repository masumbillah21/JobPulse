<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cateList = JobCategory::orderBy('id', 'desc')->paginate(10);

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
        $request->validate([
            'name' => 'required|unique:categories|max:20',
        ]);

        JobCategory::updateOrCreate(
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

        JobCategory::find($id)->delete();

        return redirect()->back()->with('success', 'Job Category deleted successfully!');
    }
}