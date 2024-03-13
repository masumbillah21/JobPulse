<?php

namespace App\Http\Controllers\Auth;

use App\Models\Company;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Frontend/Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $user = User::where('email', $request->email);

        if($user->company_id) {
            $company = Company::where('id', $user->company_id)->where('status', 0)->count();
        }else{
            $company = 0;
        }

        if ($user->where('user_type', UserTypeEnum::SYSTEM)->count() == 1
            && $user->where('status', 0)->count() == 1
            && $company == 0
        ) {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
        }

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
