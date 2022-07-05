<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;
    public $table = "cart";

    public static function usercartitem(){
        if(Auth::check()){
            $userCartItems = Cart::with(['product'=>function($query){
                $query->select('id','product_name','product_code','main_image','product_color','category_id');
            }])->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
        }else{
            $userCartItems = Cart::with(['product'=>function($query){
                $query->select('id','product_name','product_code','main_image','product_color','category_id');
            }])->where('session_id',Session::get('session_id'))->orderBy('id','Desc')->get()->toArray();
        }
       // dd($userCartItems);
        return $userCartItems;
    }

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }

    public static function productattrprice($product_id,$size){
        $attrprice = ProductAttribute::select('price')->where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
        return $attrprice['price'];
        //return $this->hasMany('App\Models\ProductAttribute','product_id');
    }
}
