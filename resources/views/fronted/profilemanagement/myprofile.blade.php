@extends('layouts.front_layouts.layouts')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
		<li class="active">MyProfile</li>
    </ul>
	<h3> My Profile</h3>
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
			<h5>Update your profile</h5><br/>

			<form action="{{ url('/account') }}" method="post" id="accountForm" encType="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$data['id']}}">
			  <div class="control-group">
				<label class="control-label" for="fname">First name</label>
				<div class="controls">
				  <input class="span3"  type="text" id="firstname" name="firstname" placeholder="Enter firstname" value="{{$dataname[0]}}">
				</div>
                <span style="color:red">@error('firstname'){{$message}}@enderror</span>
			  </div>
              <div class="control-group">
				<label class="control-label" for="lname">Last Name</label>
				<div class="controls">
				  <input class="span3"  type="text" id="lastname" name="lastname" placeholder="Enter lastname" value="{{$dataname[1]}}">
				</div>
                <span style="color:red">@error('lastname'){{$message}}@enderror</span>
			  </div>
              <div class="control-group">
				<label class="control-label" for="email">Email</label>
				<div class="controls">
                    <input class="span3" readonly="" value="{{$data['email']}}">
				</div>

			  </div>

              <div class="control-group">
				<label class="control-label" for="mobile">Mobile</label>
				<div class="controls">
				  <input class="span3"  type="number" name="number" id="number" placeholder="Enter mobile" value="{{$data['phone']}}">
				</div>
                <span style="color:red">@error('number'){{$message}}@enderror</span>
                </div>
                <div class="control-group">
                    <label class="control-label" for="DOB">DOB</label>
                    <div class="controls">
                    <input id="dob" class="block mt-1 w-full" type="date" name="dob" value="{{$data['DOB']}}" required />
                    </div>
                    <span style="color:red">@error('dob'){{$message}}@enderror</span>
                </div>
              <div class="control-group">

                    <label>Select Profile</label>
                    <input type="file" name="image" id="image" class="form-control" >
                    <input type="hidden" name="hidden_image" value="" class="form-control" >
                    <img id="showImage" src="/storage/images/userprofile/{{$data['Profile']}}"  width="100px">


                <span style="color:red">@error('image'){{$message}}@enderror</span>
			  </div>
			  <div class="controls">
			  <button type="submit" class="btn block">Update</button>
			  </div>
			</form>
		</div>
		</div>
		<div class="span1"> &nbsp;</div>
		<div class="span4">
			<div class="well">
			<h5>Change Password here</h5><br/>
			<form action="{{ url('/changepassworduser') }}" method="post">
                @csrf
                <div class="control-group">
                    <label class="control-label" for="Password">Current Password</label>
                    <div class="controls">
                      <input type="password" class="span3"  id="oldpassword"  name="oldpassword" required  autofocus placeholder="Enter old Password">
                    </div>
                      <span style="color:red">@error('oldpassword'){{$message}}@enderror</span>

                  </div>
			  <div class="control-group">
				<label class="control-label" for="newpassword">New Password</label>
				<div class="controls">
				  <input type="password" class="span3"  id="newpassword" name="password" required placeholder="Enter New Password">
                </div>
                  <span style="color:red">@error('password'){{$message}}@enderror</span>

			  </div>
              <div class="control-group">
				<label class="control-label" for="confirm password">Confirm Password</label>
				<div class="controls">
				  <input type="password" class="span3"  id="confirmpassword"  name="password_confirmation" required placeholder="Enter Confirm Password">
                </div>
                  <span style="color:red">@error('password_confirmation'){{$message}}@enderror</span>

			  </div>
			  <div class="control-group">
				<div class="controls">
				  <button type="submit" class="btn">Update Password</button>
				</div>
			  </div>
			</form>
		</div>
		</div>
	</div>

</div>
@endsection
