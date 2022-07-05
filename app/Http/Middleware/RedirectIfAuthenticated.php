<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
       // dd("check");
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if(!empty(Auth::guard($guard)->user()) && Auth::guard($guard)->user()->UserType == 1){
                    //dd(Auth::guard());
                    return redirect('/');
                }
                elseif(!empty(Auth::guard($guard)->user()) && Auth::guard($guard)->user()->UserType == 2){
                    // dd($guard);
                    return redirect('/admin/dashboard');
                }
            }
        }

        return $next($request);
    }
}
