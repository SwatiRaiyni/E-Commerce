<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Models\Cart;
//use Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthenticatedSessionController extends Controller
{

    //Foundatuse AuthenticatesUsers;

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function __construct()
    {
        $this->middleware('guest')->except('destroy');

    }
    protected $maxAttempts = 1; // Default is 5
    protected $decayMinutes = 1; // Default is 1
    public function create()
    {
        //dd("login");
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        //dd("login");



        $request->authenticate();

        $request->session()->regenerate();

        // if(Auth::user()->UserType == 1){
        //     if(Auth::user()->IsApproved == 1){

        //         //update user cart with user_id
        //         if(!empty(Session::get('session_id'))){
        //             $user_id = Auth::user()->id;
        //             $session_id = Session::get('session_id');
        //             Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
        //         }
        //         //send mail

        //         // $email = Auth::user()->email;
        //         // $message = ['name' => Auth::user()->name , 'email' => Auth::user()->email , 'phone' => Auth::user()->phone];
        //         // Mail::send('emails.code',$message , function($message) use($email){
        //         //     $message->to($email)->subject('Welcome to E-commerce Website');
        //         // });
        //         return redirect('/');
        //     }else{
        //         Auth::guard('web')->logout();
        //        // $request->session()->invalidate();
        //        // $request->session()->regenerateToken();
        //         session()->flash('msg', 'You are not apporved by admin!');
        //         return redirect('login');
        //     }
        // }
        // }elseif(Auth::user()->UserType == 2){
        //     //dd("yes");
        //     if(Auth::user()->IsApproved == 1){
        //         return redirect('admin/dashboard');
        //     }else{
        //         Auth::guard('web')->logout();
        //         $request->session()->invalidate();
        //         $request->session()->regenerateToken();
        //         session()->flash('msg', 'You are not apporved by admin!');
        //         return redirect('login');
        //     }
        // }

        //return redirect()->intended(RouteServiceProvider::HOME);
        if(Auth::guard('web')->user() && Auth::guard('web')->user()->UserType == 1){
            if(Auth::user()->IsApproved == 1){
                if(!empty(Session::get('session_id'))){
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                }
                // $email = Auth::user()->email;
                // $message = ['name' => Auth::user()->name , 'email' => Auth::user()->email , 'phone' => Auth::user()->phone];
                // Mail::send('emails.code',$message , function($message) use($email){
                //     $message->to($email)->subject('Welcome to E-commerce Website');
                // });
                return redirect('/');
           }
            else{

                Auth::guard('web')->logout();
               // $request->session()->invalidate();
               // $request->session()->regenerateToken();
                session()->flash('msg', 'You are not apporved by admin!');
                return redirect('login');
            }
       }else{
        Auth::guard('web')->logout();
       // $request->session()->invalidate();
        //$request->session()->regenerateToken();
        session()->flash('msg', 'You not have a admin access!');
        return redirect('/login');
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
        Auth::guard('web')->logout();
        //$request->session()->invalidate();
        //$request->session()->regenerateToken();
        return redirect('/');
    }
}
