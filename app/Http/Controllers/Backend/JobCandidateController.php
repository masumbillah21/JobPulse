<?php

namespace App\Http\Controllers\Backend;

use App\Models\Job;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Training;
use App\Models\Education;
use App\Models\Reference;
use App\Enum\UserRoleEnum;
use App\Models\Experience;
use App\Models\JobCandidate;
use Illuminate\Http\Request;
use App\Models\PersonalDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JobCandidateController extends Controller
{
    public function candidateList()
    {
        if(Auth::user()->roles->pluck('name')->contains(UserRoleEnum::SUPER_ADMIN->value)){
            $candidatesList = JobCandidate::with(['job', 'user'])->orderBy('id')->get();
        }else{
            $companyId = Auth::user()->company_id;
            $candidatesList = JobCandidate::with(['job', 'user'])
            ->whereHas('job', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->get();
        }
        
        return Inertia::render('Backend/Candidates/Index', [
            'candidatesList' => $candidatesList
        ]);
    }

    public function candidateSingle(string $id)
    {
        $jobCandiate = JobCandidate::find($id);

        $data['candidate'] = $jobCandiate;
        $data['job'] = $jobCandiate->job;
        $data['personal_info'] = User::find($jobCandiate->user_id);
        $data['resume'] = PersonalDetail::where('user_id', $jobCandiate->user_id)->first();
        $data['education'] = Education::where('user_id', $jobCandiate->user_id)->get();
        $data['training'] = Training::where('user_id', $jobCandiate->user_id)->get();
        $data['experience'] = Experience::where('user_id', $jobCandiate->user_id)->get();
        $data['reference'] = Reference::where('user_id', $jobCandiate->user_id)->get();
        
        return Inertia::render('Backend/Candidates/Single', [
            'resumeData' => $data
        ]);
    }

    public function candidateStatus(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:job_candidate,id',
            'status' => 'required|in:selected,rejected',
        ]);

        $candidate = JobCandidate::find($request->candidate_id);
        $candidate->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Candidate status updated successfully');
    }

    public function applicationList()
    {
        if (Auth::user()->roles->pluck('name')->contains(UserRoleEnum::SUPER_ADMIN->value)) {
            $applicationList = JobCandidate::with('job', 'job.company')->get();
        }else{
            $applicationList = JobCandidate::with('job', 'job.company')->whereHas('user', function($query){
                $query->where('user_id', Auth::id());
            })->get();
        }
        
        return Inertia::render('Backend/Applications/Index', [
            'applicationList' => $applicationList
        ]);
    }

    public function applicationSingle(string $id)
    {
        $jobCandiate = JobCandidate::findOrFail($id);
        if(!$jobCandiate){
            abort(404);
        }
        if (Auth::user()->roles->pluck('name')->contains(UserRoleEnum::SUPER_ADMIN->value)) {
            $application = $jobCandiate->with('job', 'job.company', 'job.category', 'job.user')->first();
        }else{
            if(!$jobCandiate->user_id != Auth::id()){
                abort(404);
            }
            $application = $jobCandiate->with('job', 'job.company', 'job.category','job.user')->whereHas('user', function($query){
                $query->where('user_id', Auth::id());
            })->first();
        }
        return Inertia::render('Backend/Applications/Single', [
            'applicationData' => $application
        ]);
    }
}
