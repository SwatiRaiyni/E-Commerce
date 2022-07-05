<?php use App\Models\Product; ?>
@extends('layouts.front_layouts.layouts')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
		<li class="active"><a href="{{ url('/myorders')}}">Orders</a></li>
    </ul>
	<h3> Order #{{$orderdetails['id']}} Details
        @if($orderdetails['order_status'] == 1)
        {{-- <span style="float:right"><a href="{{ url('/orders/cancel/'.$orderdetails['id']) }}"><button type="button" class="btn block btncancelorder">Cancel Order</button></a></span> --}}
        <button type="button" style="float:right" class="btn btn-primary " data-toggle="modal" data-target="#CancelModal">
            Cancel Order
        </button>
        @endif
        @if($orderdetails['order_status'] == 4)

        <button type="button" style="float:right" class="btn btn-primary" data-toggle="modal" data-target="#ReturnModal">
            Return/Exchange Order
        </button>
        @endif
    </h3>
    @if(Session::get('status'))
    <div class="alertnew1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <strong>Hey!</strong> {{Session::get('status')}}
      </div>
    @endif
    @if(Session::get('status1'))
    <div class="alertnew">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <strong>Hey!</strong> {{Session::get('status1')}}
      </div>
    @endif
	<hr class="soft"/>


    <div class="row">
		<div class="span4">
            <table class="table table-bordered table-striped">
                <tr>
                    <td colspan="2"><strong>Order Details</strong></td>
                </tr>
                <tr>
                    <td>Order Date</td>
                    <td> {{date('d-m-Y',strtotime($orderdetails['created_at']))}}</td>
                </tr>
                <tr>
                    <td>Order Status</td>
                    <td>
                        @if ($orderdetails['order_status'] == 1)
                            Pending
                        @elseif($orderdetails['order_status'] == 2)
                            Assigned
                        @elseif($orderdetails['order_status'] == 3)
                            Cancelled
                        @elseif ($orderdetails['order_status'] == 4)
                            Completed
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Order Total</td>
                    <td>Rs. {{$orderdetails['grand_total']}}</td>
                </tr>
                <tr>
                    <td>Payment Method</td>
                    <td>{{$orderdetails['payment_method']}}</td>
                </tr>

            </table>
        </div>
        <div class="span4">
            <table class="table table-bordered table-striped">
                <tr>
                    <td colspan="2"><strong>Delivery Address</strong></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>{{$orderdetails['name']}}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>{{$orderdetails['address']}}</td>
                </tr>
                <tr>
                    <td>pincode</td>
                    <td>{{$orderdetails['pincode']}}</td>
                </tr>
                <tr>
                    <td>Mobile</td>
                    <td>{{$orderdetails['mobile']}}</td>
                </tr>

            </table>
        </div>
    </div>


	<div class="row">
		<div class="span8">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Product Image</th>
                    <th>Productcode</th>
                    <th>Prdouct Name</th>
                    <th>Product Size</th>
                    <th>Product color</th>
                    <th>Prodcut Qty</th>
                    <th>Item status</th>
                </tr>
                @foreach ($orderdetails['orderproduct'] as $product)
                <tr>
                    <td><?php $image =  Product::getproductimage($product['product_id']) ?>
                        <img src="/storage/images/products_images/{{ $image}}" alt="" style="width:80px"/>
                    </td>
                    <td> {{$product['product_code']}}</td>
                    <td>{{$product['product_name']}}</td>
                    <td>{{$product['product_size']}}</td>
                    <td>{{$product['product_color']}}</td>
                    <td>{{$product['product_qty']}}</td>
                    <td>{{$product['item_status']}}</td>
                </tr>
                @endforeach
            </table>
		</div>
    </div>
</div>


<div class="modal fade" id="CancelModal" tabindex="-1" role="dialog" aria-labelledby="CancelModal" aria-hidden="true">
    <form method="POST" action="{{ url('/orders/cancel/'.$orderdetails['id']) }}">
        @csrf
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="CancelModal">Reason for Cancellation</h5>
            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}
            </div>
            <div class="modal-body">
                <select name="reason" id='cancelReason'>
                    <option value="">Select Reason</option>
                    <option value="Order Created by mistake">Order Created by mistake</option>
                    <option value="Item Not Arrived On Time">Item Not Arrived on Time</option>
                    <option value="Shipping cost is to high">Shipping cost is to high</option>
                    <option value="Found Cheaper SomeWhere Else">Found Cheaper SomeWhere Else</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger btncancelorder">Cancel Order</button>
            </div>
        </div>
        </div>
    </form>
</div>
<!--Return Modal-->
<div class="modal fade" id="ReturnModal" tabindex="-1" role="dialog" aria-labelledby="ReturnModal" aria-hidden="true">
    <form method="POST" action="{{ url('/orders/return/'.$orderdetails['id']) }}">
        @csrf
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ReturnModal">Reason for Return/Exchange</h5>
            </div>
            <div class="modal-body">
                <select name="return_exchange" id="returnExchange">
                    <option value="">Select Return/Exchange</option>
                    <option value="Return">Return</option>
                    <option value="Exchange">Exchange</option>
                </select>
            </div>
            <div class="modal-body">
                <select name="product_info" id="return_product">
                    <option value="">Select Product</option>
                    @foreach ($orderdetails['orderproduct'] as $product)
                        @if($product['item_status']  != "Return Initiated")
                        <option value="{{$product['product_code']}}-{{$product['product_size']}}">{{$product['product_code']}}-{{$product['product_size']}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="modal-body" id="requiresize">
                <select name="required_size" id="productsize" >
                    <option value="">Select Required size</option>
                </select>
            </div>
            <div class="modal-body">
                <select name="reason" id='returnReason'>
                    <option value="">Select Reason</option>
                    <option value="Perfromance or quality not so good">Perfromance or quality not so good</option>
                    <option value="Product is damaged">Product is damaged</option>
                    <option value="Item Arrived to late">Item Arrived to late</option>
                    <option value="Wrong item was sent">Wrong item was sent</option>
                    <option value="Item defective or dosn't work">Item defective or dosn't work</option>
                    <option value="Required small size or other">Required small size or other</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="modal-body">
                <textarea name="comment" placeholder="comment" id="comment"></textarea>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger btnreturnorder">Submit</button>
            </div>
        </div>
        </div>
    </form>
</div>
@endsection
