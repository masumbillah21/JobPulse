<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Validation\Rule;
use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Helper\GenerateUniqueSlug;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Company::class);

        $companyData = Company::get();

        return Inertia::render('Backend/Company/Index', [
            'companyData' => $companyData
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Company::class);

        $user = Auth::user();
        $companyData = $user->company()->first();

        return Inertia::render('Backend/Company/Edit', [
            'companyData' => $companyData
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Company::class);

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

        $slug = GenerateUniqueSlug::slug($request->name, Company::class);

        Company::create([
            'name' => $request->name,
            'description' => $request->description,
            'company_type' => $request->company_type,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'logo' => $image_path,
            'company_size' => $request->company_size,
            'slug' => $slug,
        ]);
        
        return redirect()->back()->with('success', 'Company create successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $this->authorize('view', Company::class);

        return Inertia::render('Backend/Company/Show', [
            'companyDetails' => $company
        ]);
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
        $this->authorize('update', Company::class);

        $validation = $request->validate([
            'name' => 'required|'.Rule::unique(Company::class)->ignore($company->id),
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

        if($request->name != $company->name){
            $validation['slug'] = GenerateUniqueSlug::slug($request->name, Company::class);
        }

        $company->update($validation);
        
        return redirect()->back()->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function changeStatus(string $id)
    {
        $this->authorize('delete', Company::class);

        $company = Company::find($id);
        $comStatus = $company->status == 1 ? 0 : 1;
        $company->update(['status' => $comStatus]);

        return redirect()->back()->with('success', 'Company status updated successfully');
    }
}
