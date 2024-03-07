<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Models\Company;
use App\Models\Feature;
use App\Enum\UserRoleEnum;
use App\Enum\UserTypeEnum;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('plugin.view')) {
            abort(403);
        }

        $features = Feature::with('company')->get();

        return Inertia::render('Backend/Feature/Index', ['features' => $features]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermission('plugin.create')) {
            abort(403);
        }

        return Inertia::render('Backend/Feature/Edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('plugin.create')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        Feature::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ]);
        return redirect()->back()->with('success', 'Feature created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Feature $feature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Auth::user()->hasPermission('plugin.update')) {
            abort(403);
        }

        return Inertia::render('Backend/Feature/Edit', [
            'feature' => Feature::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::user()->hasPermission('plugin.update')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $feature = Feature::find($id);

        $feature->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Feature updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feature $feature)
    {
        if (!Auth::user()->hasPermission('plugin.delete')) {
            abort(403);
        }

        $feature->delete();
        return redirect()->back()->with('success', 'Feature deleted successfully');
    }

    public function activeDeactive(string $id)
    {
        if (!Auth::user()->hasPermission('plugin.use')) {
            abort(403);
        }
        
        $company = Company::find(Auth::user()->company_id);

        $feature = Feature::findOrFail($id);
        if ($company && $feature) {
            if (!$company->features()->where(['company_id' => Auth::user()->company_id, 'feature_id' => $id])->exists()) {
                $feature->company()->attach($company);
            } else {
                $feature->company()->detach($company);
            }
        } else {
            return redirect()->back()->withErrors('Invalid Request');
        }

        return redirect()->back()->with('success', 'Request procced successfully');
    }
}
