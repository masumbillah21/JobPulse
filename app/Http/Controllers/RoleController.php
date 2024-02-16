<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = Auth::user()->company_id;
        $roles = Role::where('company_id', $companyId)->paginate(10);
        return Inertia::render('Roles/Index', [
            'rolesData' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Roles/Edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $companyId = Auth::user()->company_id;

        Role::create([
            'name' => $request->name,
            'company_id' => $companyId
        ]);
        return redirect()->back()->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return Inertia::render('Roles/Edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);

        $companyId = Auth::user()->company_id;

        if($role->company_id != $companyId) {
            return redirect()->back()->with('error', 'Role not found');
        }

        $role->update($validate);

        return redirect()->back()->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $companyId = Auth::user()->company_id;

        if($role->company_id != $companyId) {
            return redirect()->back()->with('error', 'Role not found');
        }

        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully');
    }
}
