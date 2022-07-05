<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('destroy');

    }
    public function create()
    {
        return view('backend.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

       // dd(Auth::user());
        if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->UserType == 2){
            if(Auth::guard('admin')->user()->IsApproved == 1){//dd("yes");
                return redirect('admin/dashboard');
            } else{
                Auth::guard('admin')->logout();
               // $request->session()->invalidate();
               // $request->session()->regenerateToken();
                session()->flash('msg', 'You are not apporved by admin!');
                return redirect('admin/login');
            }
        }
        else{
            Auth::guard('admin')->logout();
            //$request->session()->invalidate();
            //$request->session()->regenerateToken();
            session()->flash('msg', 'You not have user access!');
            return redirect('admin/login');
           }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
      // dd("inside admin");
        Auth::guard('admin')->logout();
        //Auth::guard('admin')->logout()
      //  $request->session()->invalidate();

//        $request->session()->regenerateToken();

        return redirect('/');
    }
}
