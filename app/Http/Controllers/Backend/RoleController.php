<?php

namespace App\Http\Controllers\Backend;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use App\Models\AsideMenu;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Role::class);

        $roles = Role::with('permissions')->paginate(10);
    
        return Inertia::render('Backend/Roles/Index', [
            'rolesData' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        $permissionList = Permission::pluck('name', 'id');

        return Inertia::render('Backend/Roles/Edit', [
            'permissionList' => $permissionList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        $request->validate([
            'name' => 'required',
            'permissions' => 'required|array'
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        $role->permissions()->attach($request->permissions);

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
        $this->authorize('update', $role);

        $permissionList = Permission::pluck('name', 'id');

        return Inertia::render('Backend/Roles/Edit', [
            'role' => $role->load('permissions:id'),
            'permissionList' => $permissionList
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('update', Role::class);

        $validate = $request->validate([
            'name' => 'required',
            'permissions' => 'required|array'
        ]);

        $companyId = Auth::user()->company_id;

        if($role->company_id != $companyId) {
            return redirect()->back()->with('error', 'Role not found');
        }

        $role->update($validate);

        $role->permissions()->sync($request->permissions);

        return redirect()->back()->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', Role::class);

        $companyId = Auth::user()->company_id;

        if($role->company_id != $companyId) {
            return redirect()->back()->with('error', 'Role not found');
        }

        $role->permissions()->detach();
        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully');
    }
}