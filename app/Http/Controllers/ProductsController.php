<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Cart;
use App\Models\Ratings;



class ProductsController extends Controller
{
    public function listing(Request $res,$page = 1){
        if($res->ajax()){
            $data = $res->all();
            $url = $data['url'];
            $categorycount = Category::where(['url'=>$url,'status'=>1])->count();
            // dd($categorycount);
             if($categorycount > 0){
                 $catdetail = Category::categorydetails($url);
                 $categoryproduct = Product::whereIn('category_id',$catdetail['catId'])->where('status',1);

                 //if sort option select
                 if(isset($data['sort']) && !empty($data['sort'])){
                     if($data['sort'] == 'product_latest'){
                         $categoryproduct->orderBy('id','DESC');
                     }elseif($data['sort'] == 'product_name_a_z'){
                         $categoryproduct->orderBy('product_name','Asc');
                     }elseif($data['sort'] == 'product_name_z_a'){
                         $categoryproduct->orderBy('product_name','DESC');
                     }elseif($data['sort'] == 'product_low'){
                         $categoryproduct->orderBy('product_price','Asc');
                     }elseif($data['sort'] == 'product_high'){
                         $categoryproduct->orderBy('product_price','DESC');
                     }
                 }
                 else{
                     $categoryproduct->orderBy('id','DESC');
                 }
                $paginate = 4;
                $skip = ($page * $paginate) - $paginate;
                $prevURL = $nextURL = '';

                if ($skip > 0){
                    $prevURL = $page - 1;
                }
                $categoryproduct = $categoryproduct->skip($skip)->take($paginate)->get();
                if($categoryproduct->count() >0){
                    if($categoryproduct->count() >= $paginate){
                        $nextURL = $page + 1;
                    }

                return view('fronted.productmanagement.ajax_products')->with(['catdetail'=>$catdetail,'categoryproduct'=>$categoryproduct,'url'=>$url,'prevURL'=>$prevURL,'nextURL'=>$nextURL]);
            }

             }else{
                 abort(404);
             }

        }else{
         $url = Route::getFacadeRoot()->current()->uri();
            $categorycount = Category::where(['url'=>$url,'status'=>1])->count();
            // dd($categorycount);
             if($categorycount > 0){
                 $catdetail = Category::categorydetails($url);
                 $categoryproduct = Product::whereIn('category_id',$catdetail['catId'])->where('status',1);

                 //if sort option select

                     $categoryproduct = $categoryproduct->paginate(3);

                 return view('fronted.productmanagement.products')->with(['catdetail'=>$catdetail,'categoryproduct'=>$categoryproduct,'url'=>$url]);

             }else{
                 abort(404);
             }
        }

    }

    public function productdetails($id){
        $productdetail = Product::with(['category','attributes'=>function($query){
            $query->where('status',1);
        }])->find($id)->toArray();//dd($productdetail);
        $stock = ProductAttribute::where('product_id',$id)->sum('stock');
        $relatedproduct = Product::where('category_id',$productdetail['category']['id'])->where('id','!=',$id)->limit(3)->inRandomOrder()->get()->toArray();//dd($relatedproduct);
        //to get rating of product
        $ratings = DB::table('ratings')->join('users','users.id','=','ratings.user_id')->where('ratings.status',1)->where('ratings.product_id',$id)->get();

        //Average rating of product
        $ratingsum = Ratings::where('status',1)->where('product_id',$id)->sum('ratings');
        $ratingcount = Ratings::where('status',1)->where('product_id',$id)->count();//dd($ratingcount);

        if($ratingcount > 0){
        $avgcount = round($ratingsum / $ratingcount);
        $avgstarcount = round($ratingsum / $ratingcount);
        }else{
            $avgcount = 0;
            $avgstarcount = 0;
        }
        return view('fronted.productmanagement.product_details')->with(['productdetail'=>$productdetail,'stock'=>$stock,'relatedproduct'=>$relatedproduct,'rating'=>$ratings,'avgcount'=>$avgcount,'avgstarcount'=>$avgstarcount]);
    }

    public function getproductprice(Request $res){
        if($res->ajax()){
            $data = $res->all();


            $getDiscountedAttribute = Product::getDiscountedAttribute($data['product_id'],$data['size']);
            //dd($getDiscountedAttribute);getDiscountedAttribute
            return $getDiscountedAttribute;

        }
    }

    public function addtocart(Request $res){
        if($res->isMethod('post')){
            $data = $res->all();
            //dd($data);
            // if($data['quantity'] <= 0 || $data['quantity'] = ""){
            //     $data['quantity'] = 1;
            // }
            //check stock is available
            $getProductStock = ProductAttribute::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->first()->toArray();
           // dd($getProductStock);
            if($getProductStock['stock'] < $data['quantity']){
                $res->session()->flash('status1',"Required Quantity is not available");
                return redirect()->back();
            }

             //generate session id if not exists
             $session_id  = Session::get('session_id');
             if(empty($session_id)){
                 $session_id = Session::getId();
                 Session::put('session_id',$session_id);
             }


            //check product if already exist in cart

            if(Auth::check()){
                $countProduct = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>Auth::user()->id])->count();
            }else{
                $countProduct = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>Session::get('session_id')])->count();
            }

            if($countProduct > 0){
                $res->session()->flash('status1',"Product already exist in cart");
                return redirect()->back();
            }


            if(Auth::check()){
                $user_id = Auth::user()->id;
            }else{
                $user_id = 0;
            }

            //save product in cart
            // Cart::insert(['session_id'=>$session_id,'product_id'=>$data['product_id'],'size' =>$data['size'],'quantity'=>$data['quantity']]);

            $cart  = new Cart;
            $cart->session_id = $session_id;
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->quantity = $data['quantity'];
            $cart->user_id = $user_id;
            $cart->save();

            $res->session()->flash('status',"Product is add in cart");
            return redirect('cart');


        }
    }

    public function cart(){
        $usercartitem = Cart::usercartitem();
        //dd($usercartitem);
        return view('fronted.cartmanagement.cart')->with(['usercartitem'=>$usercartitem]);
    }

    public function updatecartitemqty(Request $res){
        if($res->ajax()){
            $data = $res->all();
            //get cart detail
            $cartdetail = Cart::find($data['cartid']);
            //check stock is available or not
            $availablestock = ProductAttribute::select('stock')->where(['product_id'=>$cartdetail['product_id'],'size'=>$cartdetail['size']])->first()->toArray();
            if($data['qty'] > $availablestock['stock']){
                $usercartitem = Cart::usercartitem();
                return response()->json([
                    'status'=> false,
                    'message' => 'Product stock is not available',
                    'view'=>(String)View::make('fronted.cartmanagement.cart_items')->with(compact('usercartitem'))
                ]);
            }
            //check size is available or not
            $availablesize = ProductAttribute::where(['product_id'=>$cartdetail['product_id'],'size'=>$cartdetail['size'],'status'=>1])->count();
            if($availablesize == 0){
                $usercartitem = Cart::usercartitem();
                return response()->json([
                    'status'=> false,
                    'message' => 'Product size is not available',
                    'view'=>(String)View::make('fronted.cartmanagement.cart_items')->with(compact('usercartitem'))
                ]);
            }

            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
            $usercartitem = Cart::usercartitem();
            $totalcartitem = totalCartItems();
            return response()->json([
                'status'=>true,
                'totalcartitem'=>$totalcartitem,
                'view'=>(String)View::make('fronted.cartmanagement.cart_items')->with(compact('usercartitem'))
            ]);


        }
    }

    public function deletecartitem(Request $res){
        if($res->ajax()){
            $data = $res->all();
            $cartitem = Cart::where('id',$data['cartid'])->delete();
            $usercartitem = Cart::usercartitem();
            $totalcartitem = totalCartItems();
            return response()->json([
                'totalcartitem'=>$totalcartitem,
                'view'=>(String)View::make('fronted.cartmanagement.cart_items')->with(compact('usercartitem'))
            ]);
        }
    }










}
