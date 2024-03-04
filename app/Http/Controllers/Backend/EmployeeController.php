<?php

namespace App\Http\Controllers\Backend;

use Auth;
use Exception;
use App\Models\User;
use Inertia\Inertia;
use App\Enum\UserRoleEnum;
use App\Enum\UserTypeEnum;
use App\Helper\GetUserRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
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

        $authUserRole = Auth::user()->roles()->pluck('name')->first();
        
        if($authUserRole == UserRoleEnum::SUPER_ADMIN->value) {
            $employees = User::whereNot('id', Auth::user()->id)->whereNot('is_default', 1)->get();
        }else{
            $employees = User::where('company_id', Auth::user()->company)->whereNot('id', Auth::user()->id)->whereNot('is_default', 1)->paginate(10);
        }
        
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
        DB::beginTransaction();
        try{
            if (!Auth::user()->hasPermission('employee.create')) {
                abort(403);
            }
    
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'min:8'],
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'user_type' => Auth::user()->user_type,
            ]);
    
            if(Auth::user()->user_type == UserTypeEnum::COMPANY) {
                $companyEmpRole = GetUserRole::user(UserRoleEnum::COMPNANY_EMP);
                $user->roles()->attach($companyEmpRole->id);
            }else if(Auth::user()->user_type == UserTypeEnum::SYSTEM) {
                $systemEmpRole = GetUserRole::user(UserRoleEnum::SYSTEM_EMP);
                $user->roles()->attach($systemEmpRole->id);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Employee created successfully');
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->withError('Something went wrong!');
        }
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
