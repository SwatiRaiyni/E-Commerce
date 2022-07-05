<?php
use App\Models\Product;
?>
@extends('layouts.front_layouts.layouts')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
		<li class="active"> CHECKOUT</li>
    </ul>
	<h3>  CHECKOUT [ <small><span  class="totalcartitem">{{totalCartItems()}}</span> Item(s) </small> </span>]<a href="{{ url('/cart') }}" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Back to Cart </a></h3>
	<hr class="soft"/>

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

    <form name="checkoutform" id="checkoutform" action="{{url('/checkout')}}" method="post">
        @csrf
    <table class="table table-bordered">
		<tr>
            <th>
                <strong style="font-size: 13px; "> DELIVERY ADDRESSES </strong>
                <a href="{{ url('/add-edit-delivery-address') }}"  class="btn pull-right">Add Address</a>
            </th>
        </tr>
        @foreach ($deliveryaddresses as $address)
        <tr>
		<td>
                <div class="control-group" style="float:left; margin-top:-2px; margin-right:5px">
				    <input type="radio" id="address{{$address['id']}}" name="address_id" value="{{$address['id']}}" >
				</div>

				<div class="control-group">
				  <label class="control-label" for="inputPassword1">{{$address['name']}} , {{$address['address']}} {{$address['pincode']}} </label>
				</div>
        </td>
        <td>
            <a href="{{ url('/add-edit-delivery-address/'.$address['id']) }}">Edit</a>  |
            <a href="{{ url('/delete-delivery-address/'.$address['id']) }}" class="deleteaddress">Delete</a>
         </td>
		  </tr>

          @endforeach
	</table>

    <table class="table table-bordered">
        <thead>
          <tr>
            <th>Product</th>
            <th colspan="2">Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
            <?php $total_price = 0 ?>
            @foreach ($usercartitem as $item)
          <?php
          $productattrprice = Product::getDiscountedAttribute($item['product_id'],$item['size']);
          ?>

          <tr>
            <td> <img width="60" src="{{ asset('storage/images/products_images/'.$item['product']['main_image'] )}}" alt=""/></td>
            <td colspan="2">{{$item['product']['product_name']}} ({{$item['product']['product_code']}})<br/>Color : {{$item['product']['product_color']}} <br/> Size : {{$item['size']}}</td>
            <td>

                  {{$item['quantity']}}


            </td>
            <td>Rs. {{$productattrprice['product_price'] * $item['quantity'] }}</td>
            <td>Rs. {{$productattrprice['discount'] * $item['quantity'] }}</td>
            <td>Rs. {{ $productattrprice['final_price'] * $item['quantity'] }} </td>

      </tr>
      <?php  $total_price = $total_price + ($productattrprice['final_price'] * $item['quantity']);?>
      @endforeach
          <tr>
              <tr>
              <td colspan="6" style="text-align:right">Total Price:	</td>
              <td> Rs. {{$total_price}}</td>
            </tr>
             {{-- <tr>
              <td colspan="6" style="text-align:right">Total Discount:	</td>
              <td> Rs.0.00</td>
            </tr> --}}
            <tr>
              <td colspan="6" style="text-align:right"><strong> GRAND TOTAL Rs. {{$total_price}} </strong></td>
              <td class="label label-important" style="display:block"> <strong> Rs.{{$total_price}}<?php Session::put('total_price',$total_price); ?></strong></td>
            </tr>


          </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
        <tr>
            <td>
                <div class="control-group">
                        <label class="control-label"><strong> PAYMENT METHOD: </strong> </label>
                        <div class="controls">

                                <input type="radio" name="payment_getway" id="COD" value="COD">&nbsp;<strong>COD</strong>&nbsp;&nbsp;
                                <input type="radio" name="payment_getway" id="Paypal" value="Paypal">&nbsp;<strong>Paypal</strong>&nbsp;&nbsp;

                        </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>


	<a href="{{ url('/cart') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Back to Cart </a>
	<button type="submit" class="btn btn-large pull-right"> Place Order <i class="icon-arrow-right"></i></button>
</form>
</div>
@endsection
