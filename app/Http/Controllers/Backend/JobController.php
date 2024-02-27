<?php

namespace App\Http\Controllers\Backend;

use App\Helper\GenerateUniqueSlug;
use App\Models\Job;
use Inertia\Inertia;
use App\Models\JobCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Job::class);

        $companyId = Auth::user()->company_id;
        $jobsData = Job::where('company_id', $companyId)->paginate(10);
        

        return Inertia::render('Backend/Jobs/Index', [
            'jobsData' => $jobsData,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Job::class);

        $jobCateLists = JobCategory::select('id', DB::raw('name as label'))->get();
        return Inertia::render('Backend/Jobs/Edit',[
            'jobCateLists' => $jobCateLists
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Job::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string|max:255',
            'job_level' => 'required|string|max:255',
            'work_type' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'salary' => 'required|string',
            'facilities' => 'required|string',
            'skills' => 'required|string',
            'closing_date' => 'required|date',
            'status' => 'nullable|boolean',
        ]);

        $companyId = Auth::user()->company_id;

        Job::create([
            'user_id' => Auth::id(),
            'company_id' => $companyId,
            'title' => $request->title,
            'job_category_id' => $request->job_category_id,
            'location' => $request->location,
            'job_type' => $request->job_type,
            'job_level' => $request->job_level,
            'work_type' => $request->work_type,
            'skills' => $request->skills,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'responsibilities' => $request->responsibilities,
            'salary' => $request->salary,
            'facilities' => $request->facilities,
            'closing_date' => $request->closing_date,
            'slug' => GenerateUniqueSlug::slug($request->title, Job::class),
            'status' => $request->status,
        ]);
        
        return redirect()->back()->with('success', 'Job created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        $this->authorize('view', Job::class);

        $jobData = Auth::user()->company->jobs()->with(['user', 'category'])->find($job->id);
        return Inertia::render('Backend/Jobs/Show', [
            'jobData' => $jobData,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        $this->authorize('update', Job::class);

        $jobData = Auth::user()->company->jobs()->with('category')->find($job->id);
        $jobCateLists = JobCategory::select('id', DB::raw('name as label'))->get();
        
        return Inertia::render('Backend/Jobs/Edit', [
            'jobData' => $jobData,
            'jobCateLists' => $jobCateLists
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        $this->authorize('update', Job::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string|max:255',
            'job_level' => 'required|string|max:255',
            'work_type' => 'required|string|max:255',
            'skills' => 'required|string',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'salary' => 'required|string',
            'facilities' => 'required|string',
            'closing_date' => 'nullable|date',
            'status' => 'nullable|boolean',
        ]);

        if(empty($request->closing_date)) {
            unset($validated['closing_date']);
        }

        if($request->title != $job->title) {
            $validated['slug'] = GenerateUniqueSlug::slug($request->title, Job::class);
        }

        $job->update($validated);
        
        return redirect()->back()->with('success', 'Job updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $this->authorize('delete', Job::class);

        $job->delete();
        return redirect()->back()->with('success', 'Job deleted successfully');
    }

    
}
