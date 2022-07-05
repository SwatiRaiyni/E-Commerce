<?php
use App\Models\Cart;
function totalCartItems(){
    if(Auth::check()){
        $user_id = Auth::user()->id;
        $totalcartitem = Cart::where('user_id',$user_id)->sum('quantity');
    }else{
        $session_id = Session::get('session_id');
        $totalcartitem = Cart::where('session_id',$session_id)->sum('quantity');
    }
    return $totalcartitem;
}

?>
