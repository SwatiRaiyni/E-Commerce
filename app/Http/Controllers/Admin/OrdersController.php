<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\ReturnRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Section;
use App\Models\User;
use App\Models\ProductAttribute;
use App\Models\OrdersLog;
use App\Models\Order_Return;
use App\Models\ExchangeRequest;
use App\Models\Subscription;
use App\Models\OrdersProduct;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Carbon\Carbon;

class OrdersController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function orders(){
        Session::put('page','order');
        $orders = Order::with('orderproduct')->orderBy('id','Desc')->get()->toArray();
        return view('backend.ordermanagement.order')->with(compact('orders'));
    }

    public function subscription(){
        Session::put('page','subscription');
        $orders = DB::table('subscription')->join('users', 'users.id', '=', 'subscription.user_id')->select('users.*', 'subscription.*','subscription.id')->get();//dd($orders);
        return view('backend.subscription.subscription')->with(compact('orders'));
    }

    public function orderdetails($id){
        $orderdetails = Order::with('orderproduct')->where('id',$id)->first()->toArray();
        $userdetails = User::where('id',$orderdetails['user_id'])->first()->toArray();
        $orderLog = OrdersLog::where('order_id',$id)->get()->toArray();
        return view('backend.ordermanagement.orderdetails')->with(compact('orderdetails','userdetails','orderLog'));
    }

    public function updateorderstatus(Request $res){
        if($res->isMethod("post")){
            $data = $res->all();
          //  dd($data);
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            $res->session()->flash('status','Order status is updated successfully');
            $log = new OrdersLog();
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();
            return redirect()->back();
        }
    }

    public function viewOrdersInvoice($id){
        $orderdetails = Order::with('orderproduct')->where('id',$id)->first()->toArray();
        $userdetails = User::where('id',$orderdetails['user_id'])->first()->toArray();
        return view('backend.ordermanagement.orderinvoice')->with(compact('orderdetails','userdetails'));
    }

    public function viewSubscriptionInvoice($id){
        $orderdetails = Subscription::where('id',$id)->first()->toArray();


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


        $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/".$orderdetails['subscription_id'];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
           "Content-Type: application/json",
           "Authorization: Bearer ".rawurlencode($data),
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($resp);
        //dd($result);
        $userdetails = User::where('id',$orderdetails['user_id'])->first()->toArray(); //dd($userdetails);
        //$orderdetails = DB::table('subscription')->join('users', 'users.id', '=', 'subscription.user_id')->where('subscription.id',$id)->select('users.*', 'subscription.*')->get();//dd($orderdetails);
        return view('backend.subscription.subscriptioninvoice')->with(compact('orderdetails','userdetails','result'));
    }

    public function printPDFInvoice($id){
        $orderdetails = Order::with('orderproduct')->where('id',$id)->first()->toArray();
        $userdetails = User::where('id',$orderdetails['user_id'])->first()->toArray();

        $output = '<!DOCTYPE html>
        <html lang="en">
          <head>
            <meta charset="utf-8">
            <title>Example 1</title>
            <style>
            .clearfix:after {
                content: "";
                display: table;
                clear: both;
              }

              a {
                color: #5D6975;
                text-decoration: underline;
              }

              body {
                position: relative;
                width: 21cm;
                height: 29.7cm;
                margin: 0 auto;
                color: #001028;
                background: #FFFFFF;
                font-family: Arial, sans-serif;
                font-size: 12px;
                font-family: Arial;
              }

              header {
                padding: 10px 0;
                margin-bottom: 30px;
              }

              #logo {
                text-align: center;
                margin-bottom: 10px;
              }

              #logo img {
                width: 90px;
              }

              h1 {
                border-top: 1px solid  #5D6975;
                border-bottom: 1px solid  #5D6975;
                color: #5D6975;
                font-size: 2.4em;
                line-height: 1.4em;
                font-weight: normal;
                text-align: center;
                margin: 0 0 20px 0;
                background: url(dimension.png);
              }

              #project {
                float: left;
              }

              #project span {
                color: #5D6975;
                text-align: right;
                width: 52px;
                margin-right: 10px;
                display: inline-block;
                font-size: 0.8em;
              }

              #company {
                float: right;
                text-align: right;
              }

              #project div,
              #company div {
                white-space: nowrap;
              }

              table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
              }

              table tr:nth-child(2n-1) td {
                background: #F5F5F5;
              }

              table th,
              table td {
                text-align: center;
              }

              table th {
                padding: 5px 20px;
                color: #5D6975;
                border-bottom: 1px solid #C1CED9;
                white-space: nowrap;
                font-weight: normal;
              }

              table .service,
              table .desc {
                text-align: left;
              }

              table td {
                padding: 20px;
                text-align: right;
              }

              table td.service,
              table td.desc {
                vertical-align: top;
              }

              table td.unit,
              table td.qty,
              table td.total {
                font-size: 1.2em;
              }

              table td.grand {
                border-top: 1px solid #5D6975;;
              }

              #notices .notice {
                color: #5D6975;
                font-size: 1.2em;
              }

              footer {
                color: #5D6975;
                width: 100%;
                height: 30px;
                position: absolute;
                bottom: 0;
                border-top: 1px solid #C1CED9;
                padding: 8px 0;
                text-align: center;
              }

            </style>
          </head>
          <body>
            <header class="clearfix">
              <div id="logo">
                <h1>Our Invoice</h1>
              </div>


            <div id="project">
                <div><span>INVOICE TO:</span>'.$orderdetails['name'].' </div>
                <div><span>ADDRESS:</span>'.$orderdetails['address'].' </div>
                <div><span>EMAIL:</span> <a href="mailto:'.$orderdetails['email'].'">'.$orderdetails['email'].'</a></div>
                <div><span>Order Id:</span>'.$orderdetails['id'].'</div>
                <div><span>Date of order:</span> '.date('d-m-Y',strtotime($orderdetails['created_at'])).'</div>
                <div><span>Order Amount:RS.</span>'.$orderdetails['grand_total'].'</div>
            </div>
            </header>
            <main>
              <table>
                <thead>
                  <tr>
                    <th class="service">Product code</th>
                    <th class="desc">Size</th>
                    <th class="unit">Color</th>
                    <th class="qty">Price</th>
                    <th class="total">QTY</th>
                    <th class="total">TOTALS</th>
                  </tr>
                </thead>
                <tbody>';
                $subTotal = 0;
                foreach ($orderdetails['orderproduct'] as $product){
                    $output .='<tr>
                    <td class="service">'.$product['product_code'].'</td>
                    <td class="desc">'.$product['product_size'].'</td>
                    <td class="unit">'.$product['product_color'].'</td>
                    <td class="qty">USD '.$product['product_price'].'</td>
                    <td class="total">'.$product['product_qty'].'</td>
                    <td class="total">INR '.$product['product_price'] * $product['product_qty'].'</td>
                  </tr>';
                  $subTotal = $subTotal + ($product['product_price'] * $product['product_qty']);
                }
                 $output .=' </tbody><tfoot>
                  <tr>

                    <td colspan="5">SUBTOTAL</td>
                    <td class="total"> INR '. $subTotal.'</td>
                  </tr>

                  <tr>

                    <td colspan="5" class="grand total">GRAND TOTAL</td>
                    <td class="grand total"> INR '.$orderdetails['grand_total'].'</td>
                  </tr>
                </tfoot>
              </table>
              <div id="notices">

                <div class="notice">Thanks!</div>
              </div>
            </main>
            <footer>
              Invoice was created on a computer and is valid without the signature and seal.
            </footer>
          </body>
        </html>';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($output);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
        return view('backend.ordermanagement.printorderinvoice')->with(compact('orderdetails','userdetails'));
    }

    public function vieworderchart(){
        $current_month_data = Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->count();
        $last_onemonth_data = Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(1))->count();
        $last_twomonth_data = Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(2))->count();
        $last_threemonth_data = Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(3))->count();
        $orderdata = array($current_month_data,$last_onemonth_data,$last_twomonth_data,$last_threemonth_data);
        return view('backend.ordermanagement.vieworderchart')->with(compact('orderdata'));
    }

    public function returnrequest(){
        Session::put('page','returnorder');
        $return_request = Order_Return::get()->toArray();
        return view('backend.ordermanagement.returnorder')->with(compact('return_request'));
    }

    public function exchangerequest(){
        Session::put('page','exchangeorder');
        $exchange_request = ExchangeRequest::get()->toArray();
        return view('backend.ordermanagement.exchangeorder')->with(compact('exchange_request'));
    }

    public function returnrequestupdate(Request $res){
        if($res->isMethod('post')){
            $data = $res->all();
           // dd($data);
            //get return details
            $returndetail = Order_Return::where('id',$data['return_id'])->first()->toArray();
            //update return status
            Order_Return::where('id',$data['return_id'])->update(['return_status' => $data['return_status']]);

            //update orderprdouct
            OrdersProduct::where(['order_id'=>$returndetail['order_id'] , 'product_code'=>$returndetail['product_code'] , 'product_size'=>$returndetail['product_size']])->update(['item_status'=>'Return '.$data['return_status']]);

            //get user details
            $userdetails = User::select('name','email')->where('id',$returndetail['user_id'])->first()->toArray();
            //send mail

            try {

                $details = [
                    'name'=>$userdetails['name'],
                    'order_id'=>$returndetail['order_id'],
                    'return_status'=>$returndetail['return_status'],
                ];
                Mail::to(Auth::user()->email)->send(new ReturnRequest($details));
            }catch (Exception $e) {
                info("Error: ". $e->getMessage());
            }
            $res->session()->flash('status1','Return request has been '.$data['return_status'].' and email send to user');
            return redirect('admin/returnrequest');

        }
    }

    public function exchangerequestupdate(Request $res){
        if($res->isMethod('post')){
            $data = $res->all();
          //  dd($data);
            //get return details
            $exchangedetail = ExchangeRequest::where('id',$data['return_id'])->first()->toArray();
            //update return status
            ExchangeRequest::where('id',$data['return_id'])->update(['exchange_status' => $data['exchange_status']]);

            //update orderprdouct
            OrdersProduct::where(['order_id'=>$exchangedetail['order_id'] , 'product_code'=>$exchangedetail['product_code'] , 'product_size'=>$exchangedetail['product_size']])->update(['item_status'=>'Exchange '.$data['exchange_status']]);

            //get user details
            $userdetails = User::select('name','email')->where('id',$exchangedetail['user_id'])->first()->toArray();
            //send mail

            try {

                $details = [
                    'name'=>$userdetails['name'],
                    'order_id'=>$exchangedetail['order_id'],
                    'return_status'=>$exchangedetail['exchange_status'],
                ];
                Mail::to(Auth::user()->email)->send(new ReturnRequest($details));
            }catch (Exception $e) {
                info("Error: ". $e->getMessage());
            }
            $res->session()->flash('status1','Exchange request has been '.$data['exchange_status'].' and email send to user');
            return redirect('admin/exchagerequest');

        }
    }
}
