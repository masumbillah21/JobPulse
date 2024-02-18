<?php

namespace App\Http\Controllers;

use App\Models\Reference;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use App\Models\Training;
use App\Models\Education;
use Inertia\Response;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Models\PersonalDetail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $personalInfo = PersonalDetail::where('user_id', Auth::id())->first();
        $educationInfo = Education::where('user_id', Auth::id())->get();
        $trainingInfo = Training::where('user_id', Auth::id())->get();
        $experienceInfo = Experience::where('user_id', Auth::id())->get();
        $referenceInfo = Reference::where('user_id', Auth::id())->get();
        
        return Inertia::render('Backend/Resume/Index',[
            'personalInfo' => $personalInfo,
            'educationInfo' => $educationInfo,
            'trainingInfo' => $trainingInfo,
            'experienceInfo' => $experienceInfo,
            'referenceInfo' => $referenceInfo
        ]);
    }
    public function storePersonalInfo(Request $request): RedirectResponse
    {
        $request->validate([
            'alt_email' => 'required|email|unique:personal_details',
            'phone' => 'required|digits:11|unique:personal_details',
            'father_name' => 'required|max:50',
            'mother_name' => 'required|max:50',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'marital_status' => 'required|in:Single,Maried,Divorced,Widowed',
            'nationality' => 'required|max:50',
            'religion' => 'required|in:Islam,Hindhu,Christian',
            'present_address' => 'required|max:100',
            'permanent_address' => 'required|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image_path = '';

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('images', 'public');
        }

        PersonalDetail::create([
            'user_id' => Auth::user()->id,
            'alt_email' => $request->alt_email,
            'phone' => $request->phone,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'nationality' => $request->nationality,
            'religion' => $request->religion,
            'present_address' => $request->present_address,
            'permanent_address' => $request->permanent_address,
            'image' => $image_path
        ]);

        return redirect()->back()->with('success', 'Personal info saved successfully');
    }
    public function updatePersonalInfo(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'alt_email' => ['required', 'email', 'max:255', Rule::unique(PersonalDetail::class)->ignore($request->id)],
            'phone' => ['required', 'digits:11', Rule::unique(PersonalDetail::class)->ignore($request->id)],
            'father_name' => 'required|max:50',
            'mother_name' => 'required|max:50',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'marital_status' => 'required|in:Single,Maried,Divorced,Widowed',
            'nationality' => 'required|max:50',
            'religion' => 'required|in:Islam,Hindhu,Christian',
            'present_address' => 'required|max:100',
            'permanent_address' => 'required|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $personalDetail = PersonalDetail::where('user_id', Auth::id())->where('id', $id)->first();

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('images', 'public');
            Storage::disk('public')->delete($personalDetail->image);
            $validated['image'] = $image_path;

        }else{
            unset($validated['image']);
        }

        if(Auth::id() != $personalDetail->user_id){
            throw ValidationException::withMessages([
                'email' => trans('Invalid Request'),
            ]);
        }
        

        $personalDetail->update($validated);
        

        return redirect()->back()->with('success', 'Personal info saved successfully');
    }

    public function saveEducation(Request $request): RedirectResponse
    {
        $request->validate([
            'degree' => 'required|max:50',
            'institute' => 'required|max:50',
            'board_university' => 'required|max:50',
            'passing_year' => 'nullable|digits:4|integer|min:1900|max:'.(date('Y')),
            'result_type' => 'required|in:grade,division',
            'result' => 'nullable',
        ]);

        $in_progress = 0;
        if(empty($request->passing_year)){
            $in_progress = 1;
        }

        Education::updateOrCreate([
            'user_id' => Auth::user()->id, 'id' => $request->id
        ],[
            'user_id' => Auth::user()->id,
            'degree' => $request->degree,
            'institute' => $request->institute,
            'board_university' => $request->board_university,
            'passing_year' => $request->passing_year,
            'result_type' => $request->result_type,
            'in_progress' => $in_progress,
            'result' => $request->result,
        ]);

        return redirect()->back()->with('success', 'Education info saved successfully');
    }
    public function deleteEducation(string $id): RedirectResponse
    {
        Education::where('user_id', Auth::id())->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Education info deleted successfully');
    }

    public function saveTraining(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|max:50',
            'organization' => 'required|max:50',
            'location' => 'required|max:50',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|max:255',
        ]);

        $current = 0;
        if(empty($request->end_date)){
            $current = 1;
        }

        Training::updateOrCreate([
            'user_id' => Auth::user()->id, 'id' => $request->id
        ],[
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'organization' => $request->organization,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'current' => $current,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Training info saved successfully');
    }
    public function deleteTraining(string $id): RedirectResponse
    {
        Training::where('user_id', Auth::id())->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Training info deleted successfully');
    }

    public function saveExperience(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|max:50',
            'company' => 'required|max:50',
            'location' => 'required|max:50',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|max:255',
        ]);

        $current = 0;
        if(empty($request->end_date)){
            $current = 1;
        }

        Experience::updateOrCreate([
            'user_id' => Auth::user()->id, 'id' => $request->id
        ],[
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'company' => $request->company,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'current' => $current,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Experience saved successfully');
        
    }
    public function deleteExperience(string $id): RedirectResponse
    {
        Experience::where('user_id', Auth::id())->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Experience deleted successfully');
    }

    public function saveReference(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|max:50',
            'organization' => 'required|max:50',
            'phone' => 'required|digits:11|numeric',
            'email' => 'required|email',
            'relationship' => 'required|max:50',
        ]);

        $current = 0;
        if(empty($request->end_date)){
            $current = 1;
        }

        Reference::updateOrCreate([
            'user_id' => Auth::user()->id, 'id' => $request->id
        ],[
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'organization' => $request->organization,
            'phone' => $request->phone,
            'email' => $request->email,
            'relationship' => $request->relationship,
            'current' => $current,
        ]);

        return redirect()->back()->with('success', 'Reference saved successfully');
    }
    public function deleteReference(string $id): RedirectResponse
    {
        Reference::where('user_id', Auth::id())->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Reference deleted successfully');
    }
}
