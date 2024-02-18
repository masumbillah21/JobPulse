<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $companyData = $user->company()->first();

        return Inertia::render('Backend/Company/Index', [
            'companyData' => $companyData
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
            'name' => 'required',
            'description' => 'required',
            'company_type' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'website' => 'required',
            'logo' => 'required|image|max:5000',
            'company_size' => 'required',
        ]);

        $image_path = '';

        if ($request->hasFile('logo')) {
            $image_path = $request->file('logo')->store('images', 'public');
        }

        Company::create(
            [
                'name' => $request->name,
                'description' => $request->description,
                'company_type' => $request->company_type,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'website' => $request->website,
                'logo' => $image_path,
                'company_size' => $request->company_size,
            ]);
        
        return redirect()->back()->with('success', 'Company create successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $validation = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'company_type' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'website' => 'required',
            'logo' => 'nullable|image|max:5000',
            'company_size' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $image_path = $request->file('logo')->store('images', 'public');
            Storage::disk('public')->delete($company->logo);
            
            $validation['logo'] = $image_path;
        }else{
            unset($validation['logo']);
        }

        $company->update($validation);
        
        return redirect()->back()->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
