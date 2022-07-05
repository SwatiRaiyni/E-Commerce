<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Session;

class StripeController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function handleGet()
    {
        return view('fronted.cartmanagement.stripe');
    }

    public function handlePost(Request $request)
    {
       // $stripe = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Stripe::setApiKey('sk_test_51LGdnmSJujEjJwjHOPxDPrhdzHxzfFeos9pIXfPMAYwF2ByvqO8Egtify5ejX3zwkmRSDaPvZFbaiAspmNMmUvFs00WKdxvAST');
        Stripe\Charge::create ([
                "amount" => 100 ,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "This payment is tested purpose phpcodingstuff.com"
        ]);


        Session::flash('success', 'Payment has been successfully processed.');

        return redirect()->back();

    }
}
