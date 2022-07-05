@extends('layouts.front_layouts.layouts')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
		<li class="active"> Thanks</li>
    </ul>
	<h3> Thanks </h3>
	<hr class="soft"/>

    <div align="center">

        <h3>YOUR PAYMENT HAS BEED CONFIRMED</b></h3>
        <p>YOUR ORDER NUMBER IS : <b>{{Session::get('order_id')}}</b></p>
        <p> TOTAL PAYMENT TOTAL IS: <b> RS. {{Session::get('total_price')}}/- </b></p>
    </div>

</div>
@endsection

<?php
Session::forget('total_price');
Session::forget('address_id');
Session::forget('order_id');
?>
