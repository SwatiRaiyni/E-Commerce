<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Session;

class NewsletterSubscriptionController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function newsletterSubscription(){
        Session::put('page','subscribe');
        $data = NewsletterSubscriber::get()->toArray();
        return view('backend.newslettersubscripion.subscription')->with(['data'=>$data]);
    }

    public function updateemailsub(Request $res){
        if($res->ajax()){
            $data = $res->all();
           // dd($data);
           if($data['status'] == "Active"){
               $status = 0;
           }else{
               $status = 1;
           }
           NewsletterSubscriber::where('id',$data['subscriber_id'])->update(['status'=>$status]);
           return response()->json(['status'=>$status,'subscriber_id'=>$data['subscriber_id']]);
        }
    }

    public function deletesubscriber(Request $res){
        $data = NewsletterSubscriber::find($res->id);
        $data->delete();
        $res->session()->flash('status1','subscriber has been deleted Successfully!');
        return redirect()->back();
    }
}
