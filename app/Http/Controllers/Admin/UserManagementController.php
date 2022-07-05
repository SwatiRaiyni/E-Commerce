<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;


use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Carbon\Carbon;


class UserManagementController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }
    public function indexnew(){
        Session::put('page','dashboard');
        return view('backend.dashboard');
    }

    public function setting(){
        Session::put('page','setting');
        return view('backend.usermanagement.setting');
    }

    public function changepass(Request $res){

        $res->validate([
            'oldpassword' => 'required',
            'password' => 'required|string|min:6|same:password_confirmation',
            'password_confirmation' => 'required',
          ]);
          $user = \Auth::user();
          if (!\Hash::check($res->oldpassword, $user->password)) {
            return redirect()->route('settings')->with('status1', 'Current password does not match!');
        }elseif($res->oldpassword == $res->password){
            return redirect()->route('settings')->with('status1', 'You Enter Password which is same as your old password');
        }

        $user->password = \Hash::make($res->password);
        $user->save();
        return redirect()->route('settings')->with('status', 'Password successfully changed!');
    }

    public function update(Request $res){

        $res->validate([
        'firstname' => ['required', 'string', 'max:255'],
        'lastname' => ['required', 'string', 'max:255'],
        'dob' => ['required','before:today'],
        ]);

        $data = User::find($res['id']);
        $data->name = $res->firstname." ".$res->lastname;
        $data->DOB = $res->dob;

        if($res->password != ''){
            $res->validate([
            'password' => [ 'confirmed', Rules\Password::defaults()]
            ]);
        $data->password =  Hash::make($res->password);
        }
        if($res->checkactive != ''){
        $data->IsApproved = $res->checkactive;
        }
        if($res->checktype != ''){
        $data->UserType = $res->checktype;
        }
        if($res->hasfile('image')){
            Storage::disk('public')->delete('images/userprofile/'.$data->Profile);
            $image = $res->file('image');
            $destination_path = 'public/images/userprofile';
            $img = $data->Profile = uniqid().$image->getClientOriginalName();
            $path = $res->file('image')->storeAs($destination_path, $img);
        }
        $data->update();
        $res->session()->flash('status','Profile updated Successfully');
        return redirect('admin/usermangement');
    }

    public function delete(Request $req){
        $data = User::find($req->id);
        Storage::disk('public')->delete('images/userprofile/'.$data->Profile);
        $data->delete();
        $req->session()->flash('status1','User data is deleted');
        return redirect('/usermangement');
    }

    public function index(Request $res){

        if($res->ajax()) {

            if(($res->name_sel != '') || ($res->email_sel != '') || ($res->type_sel != '') || ($res->status_sel != '')){

                $name =  $res->input('name_sel');
                $email =  $res->input('email_sel');
                $typesel =  $res->input('type_sel');
                $statussel =  $res->input('status_sel');


                $q = DB::table('users');
                if($name != ''){
                    $q->where('users.name','like','%'.$name.'%');
                }if($email != ''){
                    $q->where('users.email','like',$email);
                }if($typesel != ''){
                    $q->where('users.UserType','like',$typesel);
                }if ($statussel != ''){
                    $q->where('users.IsApproved','like',$statussel);
                }

                $data = $q->select('users.name AS uname','users.DOB','users.UserType','users.Profile','users.IsApproved','users.email','users.id')->get();


            }else{
                $data =  DB::table('users')->select('users.name AS uname','users.DOB','users.UserType','users.Profile','users.IsApproved','users.email','users.id')->get();

            }
            return Datatables::of($data)->make(true);
         }

         return view('backend.usermanagement.usermanagementserver');
    }

    public function createnewuser(Request $request){
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'dob' => ['required','before:today'],
            'image' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'checktype' => ['required']
        ]);
        $data = new User;
        $data->name = $request->firstname." ".$request->lastname;
        $data->DOB = $request->dob;
        $image = $request->file('image');
        $destination_path = 'public/images/userprofile';
        $img = $data->Profile = uniqid().$image->getClientOriginalName();
        $path = $request->file('image')->storeAs($destination_path, $img);
        $data->email = $request->email;
        $data->IsApproved = $request->checkactive;
        $data->UserType = 1;
        $data->phone = "9898945309";
        $data->password = Hash::make($request->password);
        $data->save();
        $request->session()->flash('status','New User Add  Successfully');
        return redirect('admin/usermangement');

    }

    public function edituser($id){
        $data = User::find($id);
        $dataname = explode(" ", $data->name);
        return view('backend.usermanagement.edituser',['data'=>$data , 'dataname'=>$dataname ]);
    }
    public function add(Request $res){

        if($res->ajax()){
          $data1 = DB::table('roles')->where('UserType','=',$res->type_sel)->get();
          return json_encode($data1);
        }
        return view('backend.usermanagement.adduser');
    }

    public function viewuserchart(){
        $current_month_data = User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->count();
        $last_onemonth_data = User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(1))->count();
        $last_twomonth_data = User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(2))->count();
        $last_threemonth_data = User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(3))->count();
        $userdata = array($current_month_data,$last_onemonth_data,$last_twomonth_data,$last_threemonth_data);
        return view('backend.usermanagement.viewuserchart')->with(compact('userdata'));
    }

}

