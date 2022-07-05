@extends('layouts.front_layouts.layouts')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
		<li class="active">Delivery Address</li>
    </ul>
	<h3> {{$title}}  <a href="{{ url('/checkout') }}" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Back </a></h3>
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
	<div class="row">
		<div class="span4">
			<div class="well">
			<br/>

			<form @if(empty($address['id'])) action="{{ url('/add-edit-delivery-address') }}"  @else action="{{ url('/add-edit-delivery-address/'.$address['id']) }}" @endif method="post" id="deliveryAddressForm">
                @csrf

			  <div class="control-group">
				<label class="control-label" for="fname">First name</label>
				<div class="controls">
				  <input class="span3"  type="text" id="firstname" name="firstname"  @if(!empty($addressname[0])) value="{{$addressname[0]}}"  @else value="{{ old('firstname')}}" @endif  placeholder="Enter firstname" >
				</div>
                <span style="color:red">@error('firstname'){{$message}}@enderror</span>
			  </div>
              <div class="control-group">
				<label class="control-label" for="lname">Last Name</label>
				<div class="controls">
				  <input class="span3"  type="text" id="lastname" name="lastname"  @if(!empty($addressname[1])) value="{{$addressname[1]}}"  @else value="{{ old('lastname')}}" @endif  placeholder="Enter lastname" >
				</div>
                <span style="color:red">@error('lastname'){{$message}}@enderror</span>
			  </div>
              <div class="control-group">
				<label class="control-label" for="pincode">Pincode</label>
				<div class="controls">
				  <input class="span3"  type="number" id="pincode" name="pincode"  @if(!empty($address['pincode'])) value="{{$address['pincode']}}"  @else value="{{ old('pincode')}}" @endif  placeholder="Enter pincode" >
				</div>
                <span style="color:red">@error('pincode'){{$message}}@enderror</span>
			  </div>
              <div class="control-group">
				<label class="control-label" for="mobile">Mobile no.</label>
				<div class="controls">
				  <input class="span3"  type="number" id="number" name="number" @if(!empty($address['mobile'])) value="{{$address['mobile']}}"  @else value="{{ old('number')}}" @endif  placeholder="Enter number" >
				</div>
                <span style="color:red">@error('number'){{$message}}@enderror</span>
			  </div>
              <div class="control-group">
				<label class="control-label" for="mobile">Address</label>
				<div class="controls">
				  <textarea class="span3"  type="text" id="address" name="address" value="{{$address['address']}}"  placeholder="Enter number" > @if(!empty($address['address'])){{$address['address']}}  @else {{ old('address')}} @endif </textarea>
				</div>
                <span style="color:red">@error('address'){{$message}}@enderror</span>
			  </div>
                <div class="controls">
			        <button type="submit" class="btn block">Submit</button>
			    </div>
			</form>
		</div>
		</div>

	</div>
    <hr class="soft"/>
    <h3><a href="{{ url('/checkout') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Back </a></h3>
</div>
@endsection
