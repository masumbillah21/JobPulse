<?php

namespace App\Http\Middleware;

use Closure;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(Auth::user()->user_type == UserTypeEnum::SYSTEM) {
                    return redirect(RouteServiceProvider::ADMIN_HOME);
                }
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
