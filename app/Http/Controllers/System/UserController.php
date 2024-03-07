<?php

namespace App\Http\Controllers\System;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\OwerUserRequest;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class UserController extends Controller
{
     /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Frontend/System/Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (User::where('email', $credentials['email'])->where('user_type', UserTypeEnum::SYSTEM)->count() != 1
            && User::where('email', $request->email)->where('status', 0)->count() == 1) {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
        }

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
        }

        // Authentication failed
        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
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
