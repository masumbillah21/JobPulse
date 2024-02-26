<?php

namespace App\Http\Controllers\Backend;

use App\Models\Job;
use Inertia\Inertia;
use Illuminate\Http\Request;
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
            'jobsData' => $jobsData
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Job::class);

        return Inertia::render('Backend/Jobs/Edit');
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
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'salary' => 'required|string',
            'facilities' => 'required|string',
            'closing_date' => 'required|date',
            'status' => 'nullable|boolean',
        ]);

        $companyId = Auth::user()->company_id;

        Job::create([
            'user_id' => Auth::id(),
            'company_id' => $companyId,
            'title' => $request->title,
            'location' => $request->location,
            'job_type' => $request->job_type,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'responsibilities' => $request->responsibilities,
            'salary' => $request->salary,
            'facilities' => $request->facilities,
            'closing_date' => $request->closing_date,
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

        $jobData = Auth::user()->company->jobs()->with('user')->find($job->id);
        return Inertia::render('Backend/Jobs/Show', [
            'jobData' => $jobData
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        $this->authorize('update', Job::class);

        $jobData = Auth::user()->company->jobs()->find($job->id);
        return Inertia::render('Backend/Jobs/Edit', [
            'jobData' => $jobData
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
            'location' => 'required|string|max:255',
            'job_type' => 'required|string|max:255',
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
