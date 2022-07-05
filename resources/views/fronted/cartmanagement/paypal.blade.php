@extends('layouts.front_layouts.layouts')
@section('content')
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}"></script>
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
		<li class="active"> Thanks</li>
    </ul>
	<h3> Thanks </h3>
	<hr class="soft"/>

    <div align="center">
        <h3>YOUR ORDER HAS BEEN PLACED</h3>

        <p> TOTAL PAYABLE TOTAL IS: <b> RS. {{Session::get('total_price')}}/- </b></p>
        <p> PLEASE MAKE PAYMENT BY CLIKING ON BELOW PAYMENT BUTTON</p>

        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="sb-tndxg16913671@business.example.com">
            {{-- <input type="hidden" name="item_name" value="{{ Session::get('order_id') }}"> --}}
            <input type="hidden" name="amount" value="{{ round(Session::get('total_price'),2) }}">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="address1" value="{{$orderdetails['address']}}">
            <input type="hidden" name="first_name" value="{{ $name[0] }}">
            <input type="hidden" name="last_name" value="{{ $name[1] }}">
            <input type="hidden" name="zip" value="{{$orderdetails['pincode'] }}">
            <input type="hidden" name="email" value="{{Auth::user()->email}}">
            <input type="hidden" name="city" value="Ahmedabad">
            <input type="hidden" name="state" value="Gujarat">
            <input type="hidden" name="country" value="India">
            <input type="hidden" name="return" value="{{ url('paypal/success')}}">
            <input type="hidden" name="cancel_return" value="{{ url('paypal/fail')}}">
            <input type="hidden" name="notify_url" value="{{ url('paypal/ipn') }}">
            <input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
        </form>

        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post"> <!-- Identify your business so that you can collect the payments. -->
            <input type="hidden" name="business" value="sb-tndxg16913671@business.example.com"> <!-- Specify a Subscribe button. -->
            <input type="hidden" name="cmd" value="_xclick-subscriptions"> <!-- Identify the subscription. -->
            <input type="hidden" name="item_name" value="{{ Session::get('order_id') }}">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="a3" value="{{ round(Session::get('total_price'),2) }}">
            <input type="hidden" name="p3" value="1">
            <input type="hidden" name="t3" value="M">
            <input type="hidden" name="src" value="1">
            <input type="hidden" name="return" value="{{ url('paypal/success')}}">
            <input type="hidden" name="cancel_return" value="{{ url('paypal/fail')}}">
            <input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_LG.gif" alt="Subscribe">
            <img alt="" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
        </form>

        {{-- <A HREF="https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=ZDPQ8R4KARWGG">
            <IMG SRC="https://www.sandbox.paypal.com/en_GB/i/btn/btn_unsubscribe_LG.gif" BORDER="0">
        </A> --}}




</div>
@endsection

<?php
// Session::forget('total_price');
// Session::forget('order_id');
?>
