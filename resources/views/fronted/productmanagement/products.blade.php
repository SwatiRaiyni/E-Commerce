@extends('layouts.front_layouts.layouts')
@section('content')
	<div class="span9">
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
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
				<li class="active"><?php echo $catdetail['breadcrumbs'] ?></li>
			</ul>
			<h3> {{$catdetail['categorydetail']['category_name']}} <small class="pull-right"> {{count($categoryproduct)}} products are available </small></h3>
			<hr class="soft"/>
			<p>
				{{$catdetail['categorydetail']['description']}}
			</p>
			<hr class="soft"/>
			<form name="shortproduct" id="shortproduct" class="form-horizontal span6">
                <input type="hidden" name="url" id="url"  value="{{$url}}">
				<div class="control-group">
					<label class="control-label alignL">Sort By </label>
					<select name="sort" id="sort">
                        <option value="">Select</option>
                        <option value="product_latest" @if(isset( $_GET['sort']) && $_GET['sort'] == "product_latest")  selected="" @endif>Latest Products</option>
						<option value="product_name_a_z" @if(isset( $_GET['sort']) && $_GET['sort'] == "product_name_a_z")  selected="" @endif>product name A - Z</option>
						<option value="product_name_z_a" @if(isset( $_GET['sort']) && $_GET['sort'] == "product_name_z_a")  selected="" @endif>product name Z - A</option>
						<option value="product_low" @if(isset( $_GET['sort']) && $_GET['sort'] == "product_low")  selected="" @endif>Price Low to high</option>
						<option value="product_high" @if(isset( $_GET['sort']) && $_GET['sort'] == "product_high")  selected="" @endif>Price High to Low</option>
					</select>
				</div>
			</form>

			{{-- <div id="myTab" class="pull-right">
				<a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
				<a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
			</div> --}}
			<br class="clr"/>
			<div class="tab-content filter_products">
				{{-- <div class="tab-pane" id="listView">

                    @foreach ($categoryproduct as $product)
					<div class="row">
						<div class="span2">
							<img src="/storage/images/products_images/{{ $product['main_image'] }}" alt="" style="width:120px"/>
						</div>
						<div class="span4">
							<h3>{{$product['product_name']}}</h3>
							<hr class="soft"/>
							<h5>{{$product['product_name']}}</h5>
							<p>
								{{$product['description']}}
							</p>
							<a class="btn btn-small pull-right" href="product_details.html">View Details</a>
							<br class="clr"/>
						</div>
						<div class="span3 alignR">
							<form class="form-horizontal qtyFrm">
								<h3> RS.{{$product['product_price']}}</h3>
								<label class="checkbox">
									<input type="checkbox">  Adds product to compare
								</label><br/>

								<a href="product_details.html" class="btn btn-large btn-primary"> Add to <i class=" icon-shopping-cart"></i></a>
								<a href="product_details.html" class="btn btn-large"><i class="icon-zoom-in"></i></a>

							</form>
						</div>
					</div>
					<hr class="soft"/>
					@endforeach

				</div> --}}
				{{-- <div class="tab-pane  active" id="blockView">
					<ul class="thumbnails">
                        @foreach ($categoryproduct as $product)


						<li class="span3">
							<div class="thumbnail">
								<a href="#"><img src="/storage/images/products_images/{{ $product['main_image'] }}" alt="" style="width:80px"/></a>
								<div class="caption">
									<h5>{{$product['product_name']}} </h5>
									<p>
                                        {{$product['description']}}
									</p>
									<h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.{{$product['product_price']}}</a></h4>
								</div>
							</div>
						</li>

                        @endforeach
				    </ul>
					<hr class="soft"/>
				</div> --}}
                @include('fronted.productmanagement.ajax_products')
			</div>
			{{-- <a href="compare.html" class="btn btn-large pull-right">Compare Product</a> --}}
			<div class="pagination">
                @if(isset($_GET['sort']) && !empty($_GET['sort']))
                {{$categoryproduct->appends(['sort' => $_GET['sort']])->links()}}
                @else
                {{$categoryproduct->links()}}
                @endif
			</div>
			<br class="clr"/>
		</div>
@endsection
