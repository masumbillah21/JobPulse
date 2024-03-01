<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Company;
use App\Enum\UserRoleEnum;
use App\Enum\UserTypeEnum;
use App\Helper\GetUserRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Helper\GenerateUniqueSlug;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Frontend/Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if($request->terms == 0){
            return redirect()->back()->withErrors('Please accept the terms and conditions');
        }
        DB::beginTransaction();
        try{
            if($request->user_type === UserTypeEnum::CANDIDATE) {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                    'user_type' => 'required|'.Rule::in(UserTypeEnum::CANDIDATE),
                ]);
        
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                $candidateRole = GetUserRole::user(UserRoleEnum::CANDIDATE->value);

                $user->roles()->attach($candidateRole->id);
                
            }else if($request->user_type == UserTypeEnum::COMPANY) {
                
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                    'user_type' => 'required|'.Rule::in(UserTypeEnum::COMPANY),
                    'company_name' => 'required|string|max:40|unique:companies,name',
                    'description' => 'required',
                    'company_type' => 'required',
                    'address' => 'required',
                    'phone' => 'required|digits:11',
                    'website' => 'required',
                    'company_size' => 'required',
                ]);
    
                $company = Company::create([
                    'name' => $request->company_name,
                    'description' => $request->description,
                    'company_type' => $request->company_type,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'website' => $request->website,
                    'company_size' => $request->company_size,
                    'slug' => GenerateUniqueSlug::slug($request->company_name, Company::class)
                ]);
    
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'user_type' => UserTypeEnum::COMPANY,
                    'company_id' => $company->id
                ]);

                $companyAdminRole = GetUserRole::user(UserRoleEnum::COMPNANY_ADMIN->value);

                $user->roles()->attach($companyAdminRole);
                
            }else{
                return redirect()->back()->withErrors('Invalid Request.');
            }
            event(new Registered($user));
    
            Auth::login($user);
            DB::commit();
            return redirect(RouteServiceProvider::HOME);

        }catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }

        
    }
}
