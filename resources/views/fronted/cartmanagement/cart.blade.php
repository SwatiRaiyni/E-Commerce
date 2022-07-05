
@extends('layouts.front_layouts.layouts')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
		<li class="active"> SHOPPING CART</li>
    </ul>
	<h3>  SHOPPING CART [ <small><span  class="totalcartitem">{{totalCartItems()}}</span> Item(s) </small> </span>]<a href="{{ url('/') }}" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continue Shopping </a></h3>
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
    <div id="AppendCartItem">
        @include('fronted.cartmanagement.cart_items')
    </div>


            {{-- <table class="table table-bordered">
			<tbody>
				 <tr>
                  <td>
				<form class="form-horizontal">
				<div class="control-group">
				<label class="control-label"><strong> VOUCHERS CODE: </strong> </label>
				<div class="controls">
				<input type="text" class="input-medium" placeholder="CODE">
				<button type="submit" class="btn"> ADD </button>
				</div>
				</div>
				</form>
				</td>
                </tr>

			</tbody>
			</table> --}}

			<!-- <table class="table table-bordered">
			 <tr><th>ESTIMATE YOUR SHIPPING </th></tr>
			 <tr>
			 <td>
				<form class="form-horizontal">
				  <div class="control-group">
					<label class="control-label" for="inputCountry">Country </label>
					<div class="controls">
					  <input type="text" id="inputCountry" placeholder="Country">
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="inputPost">Post Code/ Zipcode </label>
					<div class="controls">
					  <input type="text" id="inputPost" placeholder="Postcode">
					</div>
				  </div>
				  <div class="control-group">
					<div class="controls">
					  <button type="submit" class="btn">ESTIMATE </button>
					</div>
				  </div>
				</form>
			  </td>
			  </tr>
            </table> -->
	<a href="{{ url('/') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
	<a href="{{ url('/checkout') }}" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>

</div>
@endsection
