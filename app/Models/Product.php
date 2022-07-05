<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    public $table = "product";

    function category(){
        return $this->belongsTo('App\Models\Category','category_id')->select('id','category_name','url');
    }

    function section(){
        return $this->belongsTo('App\Models\Section','section_id')->select('id','name');
    }

    function attributes(){
        return $this->hasMany('App\Models\ProductAttribute');
    }

    public static function getdiscountprice($product_id){
        $prodetails = Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first()->toArray();
        $catdetails = Category::select('category_discount')->where('id',$prodetails['category_id'])->first()->toArray();
        if($prodetails['product_discount'] > 0){
            //if product discount exist
            $discount_price = $prodetails['product_price'] - ($prodetails['product_price'] * $prodetails['product_discount'] /100);
        }elseif($catdetails['category_discount'] > 0){
            //if category discount exist
            $discount_price = $prodetails['product_price'] - ($prodetails['product_price'] * $catdetails['category_discount'] /100);
        }else{
            //if no any discount
            $discount_price = 0;
        }
        return $discount_price;
    }

    public static function getDiscountedAttribute($product_id,$size){
        $proattrprice = ProductAttribute::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
        $prodetails = Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first()->toArray();
        $catdetails = Category::select('category_discount')->where('id',$prodetails['category_id'])->first()->toArray();
        if($prodetails['product_discount'] > 0){
            //if product discount exist
            $final_price = $proattrprice['price'] - ($proattrprice['price'] * $prodetails['product_discount'] /100);
            $discount = $proattrprice['price'] - $final_price;
        }elseif($catdetails['category_discount'] > 0){
            //if category discount exist
            $final_price = $proattrprice['price'] - ($proattrprice['price'] * $catdetails['category_discount'] /100);
            $discount = $proattrprice['price'] - $final_price;
        }else{
            //if no any discount
            $final_price = $proattrprice['price'];
            $discount = 0;
        }

        return array('product_price'=>$proattrprice['price'],'final_price'=>$final_price,'discount'=>$discount);
    }

    public static function getproductimage($product_id){
        $getimage = Product::select('main_image')->where('id',$product_id)->first()->toArray();
        return $getimage['main_image'];
    }

    public static function getProductStatus($product_id){
        $getproductstatus = Product::select('status')->where('id',$product_id)->first()->toArray();
        return $getproductstatus['status'];
    }

    public static function getPrdouctStock($product_id,$product_size){
        $getproductstock = ProductAttribute::select('stock')->where(['product_id'=>$product_id , 'size' => $product_size ])->first()->toArray();
        return $getproductstock['stock'];
    }

    public static function getAttributecount($product_id,$product_size){
        $getproductstock = ProductAttribute::where(['product_id'=>$product_id , 'size' => $product_size ,'status'=>1])->count();
        return $getproductstock;
    }

    public static function getcategorystatus($categoryid){
        $getcategorystatus = Category::select('status')->where('id',$categoryid)->first()->toArray();
        return $getcategorystatus['status'];
    }

    public static function deleteCartProduct($product_id){
        Cart::where('product_id',$product_id)->delete();
    }

    public static function productcount($category_id){
        $productCount = Product::where(['category_id'=>$category_id,'status'=>1])->count();
        return $productCount;
    }
}
