<?php
use App\Models\Section;
$sections = Section::sections();

?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<div id="header">
    <style>
        .error{
         color: #FF0000;
        }
      </style>
	<div class="container">
		<div id="welcomeLine" class="row">
            @if(Auth::check())
			<div class="span6">Welcome!<strong> {{Auth::user()->name}}</strong></div>
            @else
            <div class="span6"></div>
            @endif
			<div class="span6">
				<div class="pull-right">

                    <input type="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" name="subscriber_email" id="subscriber_email" placeholder="Enter Email" style="margin-top:10px; height:13px; width:150px;" required="" class="@error('email') is-invalid @enderror form-control" >&nbsp;
                    @error('email')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror

                    <button class="btn btn-mini btn-primary" onclick="addSubscribe();">Subscribe</button>

                    <a href="{{ url('subscription')}}"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i><span> Subscription Plan </span> </a>

					<a href="{{ url('cart')}}"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i> [<span class="totalcartitem"> {{totalCartItems()}} </span> ] Items in your cart </span> </a>
				</div>
			</div>
		</div>
		<!-- Navbar ================================================== -->
		<section id="navbar">
		  <div class="navbar">
		    <div class="navbar-inner">
		      <div class="container">
		        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		          <span class="icon-bar"></span>
		          <span class="icon-bar"></span>
		          <span class="icon-bar"></span>
		        </a>
		        <a class="brand" href="#">E-commerce</a>
		        <div class="nav-collapse">
		          <ul class="nav">
		            <li class="active"><a href="#">Home</a></li>
                    @foreach ($sections as $section)
                    @if(count($section) > 0)
                    <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$section['name']}} <b class="caret"></b></a>
		              <ul class="dropdown-menu">
                            @foreach ($section['categories'] as $category)
                                <li class="divider"></li>
		                        <li class="nav-header"><a href="/{{$category['url']}}">{{$category['category_name']}}</a></li>
                                @foreach ($category['subcategory'] as $subcategory)
                                    <li><a href="/{{$subcategory['url']}}">{{$subcategory['category_name']}}</a></li>
                                @endforeach
                            @endforeach
                            @endif

		              </ul>
		            </li>
                    @endforeach
		            {{-- <li><a href="#">About</a></li> --}}
		          </ul>
		          {{-- <form class="navbar-search pull-left" action="#">
		            <input type="text" class="search-query span2" placeholder="Search"/>
		          </form> --}}
		          <ul class="nav pull-right">
                    @if(Auth::check())
                        <li><a href="{{ url('myorders') }}">My Orders</a></li>
                        <li class="divider-vertical"></li>
                        <li><a href="{{ url('account') }}">My Profile</a></li>
                        <li class="divider-vertical"></li>

                        <li class="nav-item">
                            <form method="POST" action="/logout" class="navbar-search pull-left">
                                @csrf
                                <a href="/logout" class="dropdown-item"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();" style="color: white; font-size:20px">

                                  <p>Log Out </p>
                                </a>
                            </form>
                          </li>
                    @else
		                <li><a href="/register">Register</a></li>
		                <li class="divider-vertical"></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    @endif

		          </ul>



		        </div><!-- /.nav-collapse -->
		      </div>
		    </div><!-- /navbar-inner -->
		  </div><!-- /navbar -->
		</section>
	</div>
</div>
