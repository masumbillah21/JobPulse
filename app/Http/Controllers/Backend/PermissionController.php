<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Permission::class);

        $permissions = Permission::orderBy('id', 'desc')->get();
        return Inertia::render('Backend/Permissions/Index', ['permissionsData' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Permission::class);

        return Inertia::render('Backend/Permissions/Edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);

        $validated = $request->validate([
            'name' => 'required|unique:permissions',
            'permission' => 'required|unique:permissions',
        ]);
        Permission::create($validated);
        return redirect()->back()->with('success', 'Permission created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        $this->authorize('update', Permission::class);

        return Inertia::render('Backend/Permissions/Edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $this->authorize('update', Permission::class);

        $validated = $request->validate([
            'name' => 'required|'.Rule::unique(Permission::class)->ignore($permission->id),
            'permission' => 'required|'.Rule::unique(Permission::class)->ignore($permission->id),
        ]);

        $permission->update($validated);

        return redirect()->back()->with('success', 'Permission updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $this->authorize('delete', Permission::class);

        $permission->delete();
        return redirect()->back()->with('success', 'Permission deleted successfully!');
    }
}
