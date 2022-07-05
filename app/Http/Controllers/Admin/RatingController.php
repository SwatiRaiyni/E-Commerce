<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ratings;
use Illuminate\Support\Facades\DB;
use Session;

class RatingController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function rating(){
        Session::put('page','rating');
        $data = DB::table('ratings')->Join('users', 'users.id', '=', 'ratings.user_id')->join('product','product.id','=','ratings.product_id')->select('ratings.*','users.email','product.product_name')->get();//dd($data);
        return view('backend.ratingmanagement.ratings')->with(['data'=>$data]);
    }

    public function updaterating(Request $res){
        if($res->ajax()){
            $data = $res->all();
           // dd($data);
           if($data['status'] == "Active"){
               $status = 0;
           }else{
               $status = 1;
           }
           Ratings::where('id',$data['rating_id'])->update(['status'=>$status]);
           return response()->json(['status'=>$status,'rating_id'=>$data['rating_id']]);
        }
    }
}
