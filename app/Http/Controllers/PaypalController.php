<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\DeliveryAddress;
use App\Models\OrdersProduct;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\plan;
use App\Models\Subscription;
use Session;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Exception;
use Twilio\Rest\Client;

class PaypalController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function paypal(){
        if(Session::has('total_price')){
           // Cart::where('user_id',Auth::user()->id)->delete();
          //  $orderdetails = Order::where('id',Session::get('order_id'))->first()->toArray(); //dd($orderdetails);
            $orderdetails = Deliveryaddress::where('id',Session::get('address_id'))->first()->toArray();
            $name = explode(" ",Auth::user()->name);
            return view('fronted.cartmanagement.paypal')->with(compact('orderdetails','name'));
        }else{
            return redirect('/cart');
        }
    }

    public function paypalsuccess(){
        if(Session::has('total_price')){
            $address_id = Session::get('address_id');
            $deliveryaddress = Deliveryaddress::where('id',Session::get('address_id'))->first()->toArray();
            $payment_method = "Prepaid";
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
              $order->order_status = 4;
              $order->payment_gatway = "Paypal";
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

              //get sms to user




            Cart::where('user_id',Auth::user()->id)->delete();


            return view('fronted.cartmanagement.successpaypal');
        }else{
            return redirect('/cart');
        }
    }

    public function sendsms(){
        $receiverNumber = "+919898945309";
        $message = "Thanks for order this product";

        try {

            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => $message]);

                dd("message send successfully");

        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }
    }

    public function paypalfail(){
        if(Session::has('order_id')){
            return view('fronted.cartmanagement.failpaypal');
        }
    }

    public function paypalipn(Request $res){
        $data = $res->all();
        $data['payment_status'] = 4;
        if($data['payment_status'] == 4){
            $order_id = Session::get('order_id');
            //update order status to complete
            Order::where('id',$order_id)->update([ 'order_status'=> 4 ]);
            $orderdetails = Order::with('orderproduct')->where('id',$order_id)->first()->toArray();

            $email = Auth::user()->email;
            $message = [
                'email' => $email,
                'name' => Auth::user()->name,
                'order_id' => $order_id,
                'orderdetails' => $orderdetails
            ];
            Mail::send('emails.order',$message,function($message) use($email){
                $message->to($email)->subject('Order Placed ');
            });

        }
    }

    public function paypalipn1(Request $res){

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
            $subscription->subscription_id = 1;
            $subscription->is_subscribe = 1;
            $subscription->Access_token = 1;
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
            $subscription->subscription_id = 1;
            $subscription->Access_token = 1;
            $subscription->subscribed_at = now();
            $subscription->save();
    }

    }

    public function gettoken(){


        $url = "https://api.sandbox.paypal.com/v1/oauth2/token";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
           "Accept: application/json",
           "Accept-Language: en_US",
           "Content-Type: application/x-www-form-urlencoded",
           "Authorization: Basic QWRXd1RzR0tadzh4ci1vYTJJc1J1ZXRMMmVSclNjdHdRcW5uYmJNUmhUbGwwSHZjOGgyWkgxRnQ1YTZsb25DWVpkUDFYc2I4TG1CZ0RzSWE6RUtwdmZVY3BXQnRYWjFHWHdqeFZPTEw4VGlWNlpqVXZGcXNsaEdUWGszbWJzZk5EWnVvQXlQaFZ2Sk13WU9IMTFVMy1semZJWWpzY0E3VlM=",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = "grant_type=client_credentials";

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);


        $data = explode(",",$resp);//dd($data);
        $token = explode(":",$data[1]);
        $data = substr($token[1], 1, -1);

        return $data;
    }

    public function product(){
        $token = $this->gettoken();

        $url = "https://api-m.sandbox.paypal.com/v1/catalogs/products";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer $token",
        "PayPal-Request-Id: PRODUCT-18062020-001",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = <<<DATA
        {
        "name": "test",
        "description": "test desc",
        "type": "SERVICE",
        "category": "SOFTWARE",
        "image_url": "https://example.com/streaming.jpg",
        "home_url": "https://example.com/home"
        }
        DATA;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $data = explode(",",$resp);//dd($data);
        $token = explode(":",$data[0]);//dd($token[1]);
        $data = substr($token[1], 1, -1);//dd($data);
        return $data;


    }

    public function plan(){
        $token = $this->gettoken();
        $product = $this->product();
        $url = "https://api-m.sandbox.paypal.com/v1/billing/plans";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer $token",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = <<<DATA
        {
        "name": "platinum",
        "description": "new plan",
        "product_id": "$product",
        "billing_cycles": [
        {
            "frequency": {
                "interval_unit": "MONTH",
                "interval_count": 1
            },
            "tenure_type": "REGULAR",
            "sequence": 1,
            "total_cycles": 5,
            "pricing_scheme": {
                "fixed_price": {
                    "value": "1",
                    "currency_code": "USD"
                }
            }
        }
        ],
        "payment_preferences": {
        "auto_bill_outstanding": true,
        "payment_failure_threshold": 1
        }
        }
        DATA;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);


        $data = explode(",",$resp);//dd($data);
        $token = explode(":",$data[0]);//dd($token[1]);
        $data = substr($token[1], 1, -1);
        setcookie("planid", $data);
       // return $data;

    }

    public function plan1(){
        $token = $this->gettoken();
        $product = $this->product();
        $url = "https://api-m.sandbox.paypal.com/v1/billing/plans";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer $token",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = <<<DATA
        {
        "name": "gold",
        "description": "new plan",
        "product_id": "$product",
        "billing_cycles": [
        {
            "frequency": {
                "interval_unit": "MONTH",
                "interval_count": 1
            },
            "tenure_type": "REGULAR",
            "sequence": 1,
            "total_cycles": 5,
            "pricing_scheme": {
                "fixed_price": {
                    "value": "2",
                    "currency_code": "USD"
                }
            }
        }
        ],
        "payment_preferences": {
        "auto_bill_outstanding": true,
        "payment_failure_threshold": 1
        }
        }
        DATA;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);


        $data = explode(",",$resp);//dd($data);
        $token = explode(":",$data[0]);//dd($token[1]);
        $data = substr($token[1], 1, -1);
        // dd($data);
        //return $data;
        setcookie("planid2", $data);

    }

    public function plan2(){
        $token = $this->gettoken();
        $product = $this->product();
        $url = "https://api-m.sandbox.paypal.com/v1/billing/plans";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer $token",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = <<<DATA
        {
        "name": "silver",
        "description": "new plan",
        "product_id": "$product",
        "billing_cycles": [
        {
            "frequency": {
                "interval_unit": "MONTH",
                "interval_count": 1
            },
            "tenure_type": "REGULAR",
            "sequence": 1,
            "total_cycles": 5,
            "pricing_scheme": {
                "fixed_price": {
                    "value": "3",
                    "currency_code": "USD"
                }
            }
        }
        ],
        "payment_preferences": {
        "auto_bill_outstanding": true,
        "payment_failure_threshold": 1
        }
        }
        DATA;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);


        $data = explode(",",$resp);//dd($data);
        $token = explode(":",$data[0]);//dd($token[1]);
        $data = substr($token[1], 1, -1);
        // dd($data);
       // return $data;
       setcookie("planid3", $data);
    }


    public function subscription(){
        $token = $this->gettoken();
       // $product = $this->product();
        $planid = $this->plan();
       // $planid = $_COOKIE['planid'];
        //echo($token);
        //echo($product);
        $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer $token",
        "PayPal-Request-Id: SUBSCRIPTION-13062022-001",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = <<<DATA
        {
        "plan_id": "$planid",
        "start_time": "2022-06-14T00:00:00Z",
        "quantity": "1",
        "shipping_amount": {
        "currency_code": "USD",
        "value": "10.00"
        },
        "subscriber": {
        "name": {
            "given_name": "John",
            "surname": "Doe"
        },
        "email_address": "customer@example.com",
        "shipping_address": {
            "name": {
            "full_name": "John Doe"
            },
            "address": {
            "address_line_1": "2211 N First Street",
            "address_line_2": "Building 17",
            "admin_area_2": "San Jose",
            "admin_area_1": "CA",
            "postal_code": "95131",
            "country_code": "US"
            }
        }
        },
        "application_context": {
        "brand_name": "walmart",
        "locale": "en-US",
        "shipping_preference": "SET_PROVIDED_ADDRESS",
        "user_action": "SUBSCRIBE_NOW",
        "payment_method": {
            "payer_selected": "PAYPAL",
            "payee_preferred": "IMMEDIATE_PAYMENT_REQUIRED"
        },
        "return_url": "https://localhost:8000/paypal/success",
        "cancel_url": "https://localhost:8000/paypal/fail"
        }
        }
        DATA;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $data = explode(",",$resp);//dd($data);
        $token = explode(":",$data[1]);//dd($token[1]);
        $data = substr($token[1], 1, -1);//dd($data);
        return $data;
    }

    public function subscription1(){
        $token = $this->gettoken();
       // $product = $this->product();
      //  $plan = $this->plan1();
      $planid2 = $_COOKIE['planid2'];
        $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer $token",
        "PayPal-Request-Id: SUBSCRIPTION-13062022-001",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = <<<DATA
        {
        "plan_id": "$planid2",
        "start_time": "2022-06-14T00:00:00Z",
        "quantity": "1",
        "shipping_amount": {
        "currency_code": "USD",
        "value": "10.00"
        },
        "subscriber": {
        "name": {
            "given_name": "John",
            "surname": "Doe"
        },
        "email_address": "customer@example.com",
        "shipping_address": {
            "name": {
            "full_name": "John Doe"
            },
            "address": {
            "address_line_1": "2211 N First Street",
            "address_line_2": "Building 17",
            "admin_area_2": "San Jose",
            "admin_area_1": "CA",
            "postal_code": "95131",
            "country_code": "US"
            }
        }
        },
        "application_context": {
        "brand_name": "walmart",
        "locale": "en-US",
        "shipping_preference": "SET_PROVIDED_ADDRESS",
        "user_action": "SUBSCRIBE_NOW",
        "payment_method": {
            "payer_selected": "PAYPAL",
            "payee_preferred": "IMMEDIATE_PAYMENT_REQUIRED"
        },
        "return_url": "https://localhost:8000/paypal/success",
        "cancel_url": "https://localhost:8000/paypal/fail"
        }
        }
        DATA;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $data = explode(",",$resp);//dd($data);
        $token = explode(":",$data[1]);//dd($token[1]);
        $data = substr($token[1], 1, -1);//dd($data);
        return $data;
    }

    public function subscription2(){
        $token = $this->gettoken();
        //$product = $this->product();
        //$plan = $this->plan2();
        $planid3 = $_COOKIE['planid3'];
        $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer $token",
        "PayPal-Request-Id: SUBSCRIPTION-13062022-001",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = <<<DATA
        {
        "plan_id": "$planid3",
        "start_time": "2022-06-14T00:00:00Z",
        "quantity": "1",
        "shipping_amount": {
        "currency_code": "USD",
        "value": "10.00"
        },
        "subscriber": {
        "name": {
            "given_name": "John",
            "surname": "Doe"
        },
        "email_address": "customer@example.com",
        "shipping_address": {
            "name": {
            "full_name": "John Doe"
            },
            "address": {
            "address_line_1": "2211 N First Street",
            "address_line_2": "Building 17",
            "admin_area_2": "San Jose",
            "admin_area_1": "CA",
            "postal_code": "95131",
            "country_code": "US"
            }
        }
        },
        "application_context": {
        "brand_name": "walmart",
        "locale": "en-US",
        "shipping_preference": "SET_PROVIDED_ADDRESS",
        "user_action": "SUBSCRIBE_NOW",
        "payment_method": {
            "payer_selected": "PAYPAL",
            "payee_preferred": "IMMEDIATE_PAYMENT_REQUIRED"
        },
        "return_url": "https://localhost:8000/paypal/success",
        "cancel_url": "https://localhost:8000/paypal/fail"
        }
        }
        DATA;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $data = explode(",",$resp);//dd($data);
        $token = explode(":",$data[1]);//dd($token[1]);
        $data = substr($token[1], 1, -1);//dd($data);
        return $data;
    }

    public function cancelsub($id){
        $token = $this->gettoken();
        $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/".$id."/suspend";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer ".rawurlencode($token),
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = <<<DATA
        {
        "reason": "Item out of stock"
        }
        DATA;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if($err){
            echo 'Error:'.$err;
        }else{

            $UpdateDetails = Subscription::where('subscription_id', '=', $id)->first();
            $UpdateDetails->is_subscribe = 0;
            $UpdateDetails->save();
            return redirect('/subscriptionnew');

        }


    }

    public function changesub($id){
       // $token = $this->gettoken();
        $subdata = Subscription::where('subscription_id',"=",$id)->get();
        foreach($subdata as $subdata1){
        $plandata = plan::where('planname','!=',$subdata1->subscription_plan)->get();
        }
        return view('fronted.subscription.changesub')->with(['plandata'=>$plandata,'id'=>$id]);
    }

    public function changesubnew($id,$pid){
       // dd($pid);
        $token = $this->gettoken();
       // $subid = $this->subscription();
       // $palnid = $this->plan2();

        $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/".rawurlencode($id)."/revise";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer ".rawurlencode($token),
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = <<<DATA
        {
            "plan_id" : "$pid"


        }
        DATA;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        var_dump($resp);
        if($err){
            echo 'Error:'.$err;
        }else{
            echo "success";
           //update subsction query
           // return redirect('/subscriptionnew');
        }




    }


    public function newsub(){
        $data = plan::get();
        $token = $this->gettoken();
        $subdata = Subscription::where('user_id',Auth::user()->id)->where('is_subscribe',1)->get();

        $subdata1 = DB::table('subscription')->where('user_id','=',Auth::user()->id)->where('is_subscribe','=',1)->first();
        //get data using subscription id

        if($subdata1 != null){
        $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/".$subdata1->subscription_id;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
           "Content-Type: application/json",
           "Authorization: Bearer ".rawurlencode($token),
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($resp);
       // dD($result);
       // var_dump($result['status_update_time']);
        }else{
            $result = "";
        }
        return view('fronted.subscription.token')->with(['data'=>$data ,'subdata'=>$subdata, 'result' => $result ]);
    }

    public function savedata(Request $res){

            $subscription = new Subscription();
            $subscription->user_id = Auth::user()->id;
            $subscription->subscription_plan = $res->planname;
            $subscription->duration = 1;
            $subscription->amount = $res->amount;
            $subscription->subscription_id = $res->s_id;
            $subscription->is_subscribe = 1;
            $subscription->subscribed_at = now();
            $subscription->Access_token = $res->token;
            $subscription->save();
            return response()->json("yes");
    }

    public function changedata(Request $res){


        Subscription::where('subscription_id', $res->s_id)->update(['subscription_plan' => $res->planname ,'amount' =>$res->amount,'Access_token'=>$res->token]);
        // $subscription = new Subscription();
        // $subscription->user_id = Auth::user()->id;
        // $subscription->subscription_plan = $res->planname;
        // $subscription->duration = 1;
        // $subscription->amount = $res->amount;
        // $subscription->subscription_id = $res->s_id;
        // $subscription->is_subscribe = 1;
        // $subscription->subscribed_at = now();
        // $subscription->Access_token = $res->token;
        // $subscription->save();
        return response()->json("yes");
}

    public function listsub(){
        $listsub = Subscription::where('user_id',Auth::user()->id)->where('is_subscribe',1)->get();
        return view('fronted.subscription.listsub')->with(['listsub'=>$listsub]);
    }


}

