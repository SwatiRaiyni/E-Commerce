<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\Cart;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
       // dd("check");
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {   //dd($request);

        // $recaptcha_secret = "6Lfz1KwgAAAAAD9UMUCzhdt2NyXOraX6zBzGG4y4";
        // $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
        // $response = json_decode($response, true);

        // if($response["success"] === true){
        //     echo "Form Submit Successfully.";die;
        // }else{
        //     echo "You are a robot";die;
        // }
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'number' => ['required','digits:10'],
            'image' => ['required'],
            'dob' => ['required','before:today'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
           // 'CaptchaCode' => 'required|valid_captcha'
        ]);
        $data = new User;
        $data->name =  $request->firstname." ".$request->lastname;
        $image = $request->file('image');
        $data->phone = $request->number;
        $destination_path = 'public/images/userprofile';
        $img = $data->Profile = uniqid().$image->getClientOriginalName();
        $path = $request->file('image')->storeAs($destination_path, $img);
        $data->DOB = $request->dob;
        $data->email = $request->email;

        $data->password =Hash::make($request->password);
        $data->save();

        event(new Registered($data));

        Auth::login($data);
        //update user cart with user_id
        if(!empty(Session::get('session_id'))){
            $user_id = Auth::user()->id;
            $session_id = Session::get('session_id');
            Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
        }
        return redirect('/');
        //return redirect(RouteServiceProvider::HOME);
    }
}
