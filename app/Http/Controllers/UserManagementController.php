<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Cart;
use App\Models\User;

class UserManagementController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }


    public function myaccount(Request $res){
        $id = Auth::user()->id;
        $data = User::find($id)->toArray();
        $dataname = explode(" ", $data['name']);

        if($res->isMethod('post')){

            $res->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'dob' => ['required','before:today'],
                'number' => ['required','digits:10']
            ]);
            $data = User::find($res->id);
            $data->name = $res->firstname." ".$res->lastname;
            $data->DOB = $res->dob;
            if($res->hasfile('image')){

                Storage::disk('public')->delete('images/userprofile/'.$data->Profile);
                $image = $res->file('image');
                $destination_path = 'public/images/userprofile';
                $img = $data->Profile = uniqid().$image->getClientOriginalName();
                $path = $res->file('image')->storeAs($destination_path, $img);
            }
            $data->UserType = 1;
            $data->phone = $res->number;
            $data->update();
            $res->session()->flash('status','User Profile updated Successfully');
            return redirect()->back();
        }

        return view('fronted.profilemanagement.myprofile')->with(['data'=>$data , 'dataname'=>$dataname]);
    }

    public function updatepassword(Request $res){
       //  dd($user);
        $res->validate([
            'oldpassword' => 'required',
            'password' => 'required|string|min:6|same:password_confirmation',
            'password_confirmation' => 'required',
          ]);
          $user = \Auth::user();

            if (!\Hash::check($res->oldpassword, $user->password)) {//dd("yes");
                //return redirect()->route('/account')->with('status1', 'Current password does not match!');
                $res->session()->flash('status1', 'Current password does not match!');
                return redirect()->back();
            }elseif($res->oldpassword == $res->password){
               // return redirect()->route('/account')->with('status1', 'You Enter Password which is same as your old password');
                $res->session()->flash('status1', 'You Enter Password which is same as your old password');
                return redirect()->back();
            }
           // dd("yes");
            $user->password = \Hash::make($res->password);
            $user->save();
            //return redirect()->route('/account')->with('status', 'Password successfully changed!');
            $res->session()->flash('status', 'Password successfully changed!');
            return redirect()->back();
    }
}
