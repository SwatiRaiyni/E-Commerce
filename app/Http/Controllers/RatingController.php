<?php

namespace App\Http\Controllers;
use App\Models\Ratings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function addrating(Request $res){
        $data = $res->all();//dd($data);
        if(!Auth::check()){
            $message = "Login Please to rate this Product";
            $res->session()->flash('status1', $message);
            return redirect()->back();
        }
        $ratingcount = Ratings::where(['user_id'=>Auth::user()->id,'product_id'=>$data['product_id']])->count();
        if($ratingcount > 0){
            $message = "Your rating already exists for this Product";
            $res->session()->flash('status1', $message);
            return redirect()->back();
        }
        if(!isset($data['rate'])){
            $message = "Add atleast one star rating for this product";
            $res->session()->flash('status1', $message);
            return redirect()->back();
        }
        else{
            $rating = new Ratings();
            $rating->user_id = Auth::user()->id;
            $rating->product_id = $data['product_id'];
            $rating->review = $data['review'];
            $rating->ratings = $data['rate'];
            $rating->status = 0;
            $rating->save();
            $message = "Thanks for rating this Product! It will be shown once approved";
            $res->session()->flash('status', $message);
            return redirect()->back();
        }
    }


}
