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
use App\Models\Order;
use App\Models\OrdersLog;
use App\Models\OrdersProduct;
use App\Models\DeliveryAddress;
use App\Models\Order_Return;
use App\Models\ExchangeRequest;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function checkout(Request $res){
        $usercartitem = Cart::usercartitem();
        if(count($usercartitem) == 0){
            $message = "Shopping cart is empty! Please add products to cart";
            $res->session()->flash('status1', $message);
            return redirect()->back();
        }

        if($res->isMethod('post')){
            $data = $res->all();

            //if admin enabled product then not visible to user
            foreach($usercartitem as $key=>$cart){
                $product_status = Product::getProductStatus($cart['product_id']);
                if($product_status == 0){
                    // Product::deleteCartProduct($cart['product_id']);
                    $message = $cart['product']['product_name']." is not available so we removed from Cart";
                    $res->session()->flash('status1', $message);
                    return redirect('/cart');
                }
                //if attribute of product is 0 by admin
                $productstock = Product::getPrdouctStock($cart['product_id'],$cart['size']);
                if($productstock == 0){
                    // Product::deleteCartProduct($cart['product_id']);
                    $message = $cart['product']['product_name']." stock is not available so we removed from Cart";
                    $res->session()->flash('status1', $message);
                    return redirect('/cart');
                }
                //if stock is set 0 by admin
                $getAttributecount = Product::getAttributecount($cart['product_id'],$cart['size']);
                if($getAttributecount == 0){
                    $message = $cart['product']['product_name']." is not available so we removed from Cart";
                    $res->session()->flash('status1', $message);
                    return redirect('/cart');
                }
                //if admin set category status to 0
                $getcategorystatus = Product::getcategorystatus($cart['product']['category_id']);
                if($getcategorystatus == 0){
                    $message = $cart['product']['product_name']." is not available so we removed from Cart";
                    $res->session()->flash('status1', $message);
                    return redirect('/cart');
                }
            }

            if(empty($data['address_id'])){
                $message = "please select Delivery Address for continue!";
                $res->session()->flash('status1', $message);
                return redirect()->back();
            }
            if(empty($data['payment_getway'])){
                $message = "please select Payment Method for continue!";
                $res->session()->flash('status1', $message);
                return redirect()->back();
            }
            Session::put('address_id',$data['address_id']);

            if($data['payment_getway'] == 'COD'){
                $payment_method = "COD";
            }else{
                $payment_method = "Prepaid";
                if($data['payment_getway'] == 'Paypal'){
                    //paypal - redirect user to paypal page after placing order
                    return redirect('/paypal');
                }
            }
            if($data['payment_getway'] == 'COD'){
            //get delivery address

            $deliveryaddress = DeliveryAddress::where('id',$data['address_id'])->first()->toArray();

            DB::beginTransaction();
            //insert order details
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryaddress['name'];
            $order->address = $deliveryaddress['address'];
            $order->pincode = $deliveryaddress['pincode'];
            $order->mobile = $deliveryaddress['mobile'];
            $order->email = Auth::user()->email;
            $order->payment_method = $payment_method;
            $order->payment_status = 1;
            $order->order_status = 1;
            $order->payment_gatway = $data['payment_getway'];
            $order->grand_total =   Session::get('total_price');
            $order->created_at = now();
            $order->save();

            //get last order id
            $order_id = DB::getPdo()->lastInsertId();

            $cartProduct = Cart::where('user_id',Auth::user()->id)->get()->toArray();
            foreach($cartProduct as $key=>$item){
                $orderproduct = new OrdersProduct();
                $orderproduct->order_id = $order_id;
                $orderproduct->user_id = Auth::user()->id;
                //get products details
                $getproductdetail = Product::where('id',$item['product_id'])->first()->toArray();
                $orderproduct->product_id = $item['product_id'];
                $orderproduct->product_code = $getproductdetail['product_code'];
                $orderproduct->product_name = $getproductdetail['product_name'];
                $orderproduct->product_color = $getproductdetail['product_color'];
                $orderproduct->product_size = $item['size'];
                $getdiscountedprice = Product::getDiscountedAttribute($item['product_id'],$item['size']);
                $orderproduct->product_price = $getdiscountedprice['final_price'];
                $orderproduct->product_qty = $item['quantity'];
                $orderproduct->item_status = "Completed";
                $orderproduct->save();


                    //reduce stock
                    $getProductstock = ProductAttribute::where(['product_id'=>$item['product_id'] , 'size' => $item['size']])->first()->toArray();
                    $newstock = $getProductstock['stock'] - $item['quantity'];
                    ProductAttribute::where(['product_id'=>$item['product_id'] , 'size' => $item['size']])->update(['stock'=>$newstock]);

            }
            //insert order_id in session variable
            Session::put('order_id',$order_id);

            DB::commit();
           // if($data['payment_getway'] == 'COD'){
                return redirect('/ordersuccess');
            }


        }
        $usercartitem = Cart::usercartitem();
        $deliveryaddresses = DeliveryAddress::deliveryAddress();
        return view('fronted.cartmanagement.checkout')->with(compact('usercartitem','deliveryaddresses'));
    }

    public function addeditdeliveryaddress(Request $res,$id = null){
        if($id == ""){
            //add address
            $title = "Add Delivery Address";
            $data = new DeliveryAddress();
            $message = "Delivery Address added successfully";
            $addressname = array();
        }else{
            //edit address
            $title = "Edit Delivery Address";
            $message = "Delivery Address updated successfully";
            $data = DeliveryAddress::find($id);
            $addressname = explode(" ", $data['name']);
        }

        if($res->isMethod('post')){
           // $data = $res->all();// dd($data);
            $res->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'number' => ['required','digits:10'],
                'address' => ['required'],
                'pincode' =>['required','integer','digits:6']
            ]);
            //$data = DeliveryAddress::find($res->id);
            $data->name = $res['firstname']." ".$res['lastname'];
            $data->mobile = $res['number'];
            $data->address = $res['address'];
            $data->pincode = $res['pincode'];
            $data->user_id = Auth::user()->id;
            $data->status = 1;
            $data->save();

            $res->session()->flash('status', $message);
            return redirect('/checkout');
        }
        return view('fronted.cartmanagement.add_edit_delivery_address')->with(['title'=>$title,'addressname'=>$addressname,'address'=>$data]);
    }

    public function deletedeliveryaddress(Request $res){
        DeliveryAddress::where('id',$res->id)->delete();
        $message = "Delivery Address deleted successfully!";
        $res->session()->flash('status1', $message);
        return redirect('/checkout');
    }

    public function ordersuccess(){
         //empty user cart table
         if(Session::has('order_id')){
            Cart::where('user_id',Auth::user()->id)->delete();
            return view('fronted.cartmanagement.ordersuccess');
         }else{
             return redirect('/cart');
         }


    }

    public function myorder(){
        $orders = Order::with('orderproduct')->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
       // dd($order);
        return view('fronted.ordermanagement.myorder')->with(compact('orders'));
    }

    public function orderdetails($id){
        $orderdetails = Order::with('orderproduct')->where('id',$id)->first()->toArray();
        return view('fronted.ordermanagement.orderdetails')->with(compact('orderdetails'));
    }

    public function cancelorder($id,Request $res){

        if($res->isMethod('post')){
            $data = $res->all();
            if(isset($data['reason']) && empty($data['reason'])){
                Session::flash('status1', 'Select reason to continue!');
                return redirect()->back();
            }
        $useridauth = Auth::user()->id;
        $useridorder = Order::select('user_id')->where('id',$id)->first();//dd($useridorder);

        if($useridauth == $useridorder->user_id){
            Order::where('id',$id)->update(['order_status'=>3]);
            //update orderlog
            $log = new OrdersLog();
            $log->order_id = $id;
            $log->order_status = 3;
            $log->reason = $data['reason'];
            $log->updated_by = "User";
            $log->save();
            Session::flash('status1', 'Order has been Cancelled');
            return redirect()->back();
        }else{
            Session::flash('status1', 'Your Order Cancellation request is not valid');
            return redirect()->back();
        }
        }
    }

    public function returnorder($id,Request $res){
        if($res->isMethod('post')){
            $data = $res->all();
            $useridauth = Auth::user()->id;
            $useridorder = Order::select('user_id')->where('id',$id)->first();//dd($useridorder);

            if($useridauth == $useridorder->user_id){

                if($data['return_exchange'] == 'Return'){
                //get product detail

                $productArr = explode("-",$data['product_info']);
                $productcode = $productArr[0];
                $productsize = $productArr[1];
                //update orderproduct table
                OrdersProduct::where(['order_id'=>$id,'product_code'=>$productcode,'product_size'=>$productsize])->update(['item_status'=>'Return Initiated']);
                //Add return request table
                $return = new Order_Return();
                $return->order_id = $id;
                $return->user_id = Auth::user()->id;
                $return->product_size = $productsize;
                $return->product_code = $productcode;
                $return->return_reason = $data['reason'];
                $return->return_status = "Pending";
                if($data['comment'] != ""){
                    $return->comment = $data['comment'];
                }else{
                    $return->comment = "";
                }
                $return->save();

                Session::flash('status1', 'Order has been Return');
                return redirect()->back();
            }else if($data['return_exchange'] == 'Exchange'){
                //get product detail
                $productArr = explode("-",$data['product_info']);
                $productcode = $productArr[0];
                $productsize = $productArr[1];
                //update orderproduct table
                OrdersProduct::where(['order_id'=>$id,'product_code'=>$productcode,'product_size'=>$productsize])->update(['item_status'=>'Exchange Initiated']);
                //Add exchange request table
                $exchange = new ExchangeRequest();
                $exchange->order_id = $id;
                $exchange->user_id = Auth::user()->id;
                $exchange->product_size = $productsize;
                $exchange->required_size = $data['required_size'];
                $exchange->product_code = $productcode;
                $exchange->exchange_reason = $data['reason'];
                $exchange->exchange_status = "Pending";
                if($data['comment'] != ""){
                    $exchange->comment = $data['comment'];
                }else{
                    $exchange->comment = "";
                }
                $exchange->save();

                Session::flash('status1', 'Order has been Exchange');
                return redirect()->back();
            }else{
                Session::flash('status1', 'Your Order Return/Exchange request is not valid');
                return redirect()->back();
            }
            }else{
                Session::flash('status1', 'Your Order Return request/Exchange is not valid');
                return redirect()->back();
            }
        }
    }

    public function getproductsize(Request $res){
        if($res->isMethod('post')){
            $datanew = $res->all();
            $newdata = explode("-",$datanew['data']);
            $code = $newdata[0];
            $size = $newdata[1];

            $productid = Product::select('id')->where('product_code',$code)->first();
            $product_id = $productid->id;
            $productsize = ProductAttribute::select('size')->where('product_id',$product_id)->where('size','!=',$size)->where('stock','>',0)->get()->toArray();
            $appendsize = '<option value="">Select Required size</option>';
            foreach($productsize as $size){
                $appendsize .= '<option value="'.$size['size'].'">'.$size['size'].'</option>';
            }
            return $appendsize;

        }
    }
}
