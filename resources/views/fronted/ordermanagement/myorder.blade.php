@extends('layouts.front_layouts.layouts')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
		<li class="active">Orders</li>
    </ul>
	<h3> My Orders</h3>
	<hr class="soft"/>

	<div class="row">
		<div class="span8">
            <table class="table table-bordered table-striped " id="totalorder">
                <tr>
                    <th>Order Id</th>
                    <th>Order Prdouct</th>
                    <th>Payment method</th>
                    <th>Grand Total</th>
                    <th>Created on</th>
                    <th>View Details</th>
                </tr>
                @foreach ($orders as $order)

                <tr>

                    <td> <a  href="{{ url('orders/'.$order['id'])}}">#{{$order['id']}} </a></td>
                    <td>
                        @foreach ($order['orderproduct'] as $pro)
                            {{$pro['product_code']}} ({{$pro['product_qty']}})<br>
                        @endforeach
                    </td>
                    <td>{{$order['payment_method']}}</td>
                    <td>{{$order['grand_total']}}</td>
                    <td>
                        {{date('d-m-Y',strtotime($order['created_at']))}}
                    </td>
                    <td> <a style="text-decoration:underline;" href="{{ url('orders/'.$order['id'])}}">View Details</a></td>

                </tr>

                @endforeach
            </table>
		</div>



	</div>

</div>
@endsection
