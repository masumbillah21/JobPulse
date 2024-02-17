<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Education;
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
    public function index()
    {
        $personalInfo = PersonalDetail::where('user_id', Auth::id())->first();
        $educationInfo = Education::where('user_id', Auth::id())->get();
        return Inertia::render('Resume/Index',[
            'personalInfo' => $personalInfo,
            'educationInfo' => $educationInfo,
        ]);
    }
    public function storePersonalInfo(Request $request)
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
    public function updatePersonalInfo(Request $request, string $id)
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

    public function saveEducation(Request $request)
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
    public function deleteEducation(string $id)
    {
        Education::where('user_id', Auth::id())->where('id', $id)->delete();
        
        return redirect()->back()->with('success', 'Education info deleted successfully');
    }

    public function storeTraining(Request $request)
    {
        
    }
    public function updateTraining(Request $request, string $id)
    {
        
    }

    public function storeExperience(Request $request)
    {
        
    }
    public function updateExperience(Request $request, string $id)
    {
        
    }

    public function storeReference(Request $request)
    {
        
    }
    public function updateReference(Request $request, string $id)
    {
        
    }
}
