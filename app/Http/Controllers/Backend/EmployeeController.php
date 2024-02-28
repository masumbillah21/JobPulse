<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Auth;
use Inertia\Inertia;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('employee.view')) {
            abort(403);
        }

        $employees = User::paginate(10);

        return Inertia::render('Backend/Employee/Index',[
            'employees' => $employees
        ] );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermission('employee.create')) {
            abort(403);
        }

        return Inertia::render('Backend/Employee/Edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('employee.create')) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'user_type' => Auth::user()->user_type,
        ]);
        
        return redirect()->back()->with('success', 'Employee created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $employee)
    {
        if (!Auth::user()->hasPermission('employee.update')) {
            abort(403);
        }

        return Inertia::render('Backend/Employee/Edit', ['employeeData' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::user()->hasPermission('employee.update')) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($id)],
            'password' => ['nullable', 'min:8'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if($request->password) {
            $data['password'] = $request->password;
        }

        User::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Employee Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::user()->hasPermission('employee.delete')) {
            abort(403);
        }

        User::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Employee deleted successfully');
    }
}
