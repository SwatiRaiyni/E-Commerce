<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\subscription;
use Session;

use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function subscription(){
        //$data = DB::table('subscription')->where('user_id',Auth::user()->id)->where('subscription_plan','simple')->get();
        //$data1 = DB::table('subscription')->where('user_id',Auth::user()->id)->where('subscription_plan','basic')->get();
        //$data2 = DB::table('subscription')->where('user_id',Auth::user()->id)->where('subscription_plan','premium')->get();
        $data = DB::table('subscription')->where('user_id',Auth::user()->id)->where('is_subscribe',1)->get();
        return view('fronted.subscription')->with(['data'=>$data]);
    }

    public function subscription1(){
        //$data = DB::table('subscription')->where('user_id',Auth::user()->id)->where('subscription_plan','simple')->get();
        //$data1 = DB::table('subscription')->where('user_id',Auth::user()->id)->where('subscription_plan','basic')->get();
        //$data2 = DB::table('subscription')->where('user_id',Auth::user()->id)->where('subscription_plan','premium')->get();
        $data = DB::table('subscription')->where('user_id',Auth::user()->id)->where('is_subscribe',1)->get();
        return view('fronted.subscription1')->with(['data'=>$data]);
    }

    public function subscription11(){
        //$data = DB::table('subscription')->where('user_id',Auth::user()->id)->where('subscription_plan','simple')->get();
        //$data1 = DB::table('subscription')->where('user_id',Auth::user()->id)->where('subscription_plan','basic')->get();
        //$data2 = DB::table('subscription')->where('user_id',Auth::user()->id)->where('subscription_plan','premium')->get();
        $data = DB::table('subscription')->where('user_id',Auth::user()->id)->where('is_subscribe',1)->get();
        return view('fronted.subscription1')->with(['data'=>$data]);
    }



    public function subscriptionsuccess(){

    $data = Subscription::where('user_id',Auth::user()->id)->where('is_subscribe',0)->get();
    if(count($data) != 0){
       foreach($data as $key=>$data1){
           if($data1['amount'] == $_GET['amount']){
            $data[$key]['is_subscribe'] = 1;
            $data[$key]->save();
           }else{
            $subscription = new subscription();
            $subscription->user_id = Auth::user()->id;
            $subscription->subscription_plan =  $_GET['plan'];
            $subscription->duration = 1;
            $subscription->amount = $_GET['amount'];
            $subscription->is_subscribe = 1;
            $subscription->subscription_id = 1;
            $subscription->subscribed_at = now();
            $subscription->save();
           }
        }
    }
    $data = Subscription::where('user_id',Auth::user()->id)->where('is_subscribe',1)->where('subscription_plan',$_GET['plan'])->get();
    if(count($data) == 0){
       // dd("yes");
        $subscription = new subscription();
            $subscription->user_id = Auth::user()->id;
            $subscription->subscription_plan =  $_GET['plan'];
            $subscription->duration = 1;
            $subscription->amount = $_GET['amount'];
            $subscription->is_subscribe = 1;
            $subscription->subscribed_at = now();
            $subscription->subscription_id = 1;
            $subscription->Access_token = 1;
            $subscription->save();
    }


        return view('fronted.successsubscriptionpaypal');
    }






}
