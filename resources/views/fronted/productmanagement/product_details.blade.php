<?php use App\Models\Product; ?>
@extends('layouts.front_layouts.layouts')
@section('content')
<style>
    *{
    margin: 0;
    padding: 0;
}
.rate {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}

/* Modified from: https://github.com/mukulkant/Star-rating-using-pure-css */
</style>
<div class="span9">

    <ul class="breadcrumb">
        <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{ url('/'.$productdetail['category']['url'])}}">{{$productdetail['category']['category_name']}}</a> <span class="divider">/</span></li>
        <li class="active">{{$productdetail['product_name']}}</li>
    </ul>
    <div class="row">

        <div id="gallery" class="span3">
            <a href="{{ asset('storage/images/products_images/'.$productdetail['main_image'] )}}" title="Blue Casual T-Shirt">
                <img src="{{ asset('storage/images/products_images/'. $productdetail['main_image'] )}}" style="width:100%" alt="Blue Casual T-Shirt"/>
            </a>


            {{-- <div class="btn-toolbar">
                <div class="btn-group">
                    <span class="btn"><i class="icon-envelope"></i></span>
                    <span class="btn" ><i class="icon-print"></i></span>
                    <span class="btn" ><i class="icon-zoom-in"></i></span>
                    <span class="btn" ><i class="icon-star"></i></span>
                    <span class="btn" ><i class=" icon-thumbs-up"></i></span>
                    <span class="btn" ><i class="icon-thumbs-down"></i></span>
                </div>
            </div> --}}
        </div>
        <div class="span6">
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
            <h3> {{$productdetail['product_name']}}</h3>
            <div>
                @if($avgcount > 0)
                <?php
                    $star = 1;
                    while($star <= $avgstarcount){?>
                        <span>&#9733;</span>
                <?php $star++; }?>({{$avgcount}})
                @endif
            </div>
            <hr class="soft"/>
            <small>{{$stock}} items in stock</small>
            <form action="{{ url('add-to-cart') }}" method="post" class="form-horizontal qtyFrm">
                @csrf
                <input type="hidden" name="product_id" value="{{$productdetail['id']}}">

                <div class="control-group">
                    <?php $disprice = Product::getdiscountprice($productdetail['id']) ?>
                    <h4 class="getPrice">
                        @if($disprice > 0)
                            <del>Rs. {{$productdetail['product_price']}}</del> Rs. {{$disprice}}
                        @else
                        Rs. {{$productdetail['product_price']}}
                        @endif

                    </h4>
                        <select class="span2 pull-left" name="size" product-id="{{$productdetail['id']}}" id="price" required>
                            <option value="">Select size</option>
                            @foreach ($productdetail['attributes'] as $attribute )
                                <option value="{{$attribute['size']}}">{{$attribute['size']}}</option>
                            @endforeach
                        </select>
                        <input type="number" name="quantity" class="span1" placeholder="Qty." required/>
                        <button type="submit" class="btn btn-large btn-primary pull-right"> Add to cart <i class=" icon-shopping-cart"></i></button>
                    </div>
                </div>
                <div class="sharethis-sticky-share-buttons"></div>
            </form>

            <hr class="soft clr"/>
            <p class="span6">
               {{$productdetail['description']}}

            </p>
            {{-- <a class="btn btn-small pull-right" href="#detail">More Details</a> --}}
            <br class="clr"/>
            {{-- <a href="#" name="detail"></a> --}}
            <hr class="soft"/>
        </div>

        <div class="span9">
            <ul id="productDetail" class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">Product Details</a></li>
                <li><a href="#profile" data-toggle="tab">Related Products</a></li>
                <li><a href="#rating" data-toggle="tab">Product Reviews</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="home">
                    <h4>Product Information</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="techSpecRow"><th colspan="2">Product Details</th></tr>
                            <tr class="techSpecRow"><td class="techSpecTD1">Name:</td><td class="techSpecTD2">{{$productdetail['product_name']}}</td></tr>
                            <tr class="techSpecRow"><td class="techSpecTD1">Code:</td><td class="techSpecTD2">{{$productdetail['product_code']}}</td></tr>
                            <tr class="techSpecRow"><td class="techSpecTD1">Color:</td><td class="techSpecTD2">{{$productdetail['product_color']}}</td></tr>

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="profile">
                    <div id="myTab" class="pull-right">
                        <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
                        <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
                    </div>
                    <br class="clr"/>
                    <hr class="soft"/>
                    <div class="tab-content">
                        <div class="tab-pane" id="listView">
                            @foreach ($relatedproduct as $product)


                            <div class="row">
                                <div class="span2">
                                    <img src="{{ asset('storage/images/products_images/'.$product['main_image'] )}}" alt="" style="width:120px"/>
                                </div>
                                <div class="span4">
                                    <h3>New | Available</h3>
                                    <hr class="soft"/>
                                    <h5>{{$product['product_name']}} </h5>
                                    <p>
                                       {{$product['product_code']}}
                                    </p>
                                    <a class="btn btn-small pull-right" href="{{ url('product/'.$product['id']) }}">View Details</a>
                                    <br class="clr"/>
                                </div>
                                <div class="span3 alignR">
                                    <form class="form-horizontal qtyFrm">
                                        <?php $disprice = Product::getdiscountprice($product['id']) ?>
                                        <h3> <a class="btn btn-primary" href="#">
                                            @if($disprice > 0)
                                                <del>Rs.{{$product['product_price']}}</del>
                                                <font color="yellow"> Rs.{{$disprice}}</font>
                                            @else
                                                Rs.{{$product['product_price']}}
                                            @endif
                                            </a>
                                        </h3>



                                        <div class="btn-group">
                                            <a href="{{ url('product/'.$product['id']) }}" class="btn btn-large btn-primary"> Add to <i class=" icon-shopping-cart"></i></a>

                                        </div>
                                    </form>
                                </div>
                            </div>


                            @endforeach
                            <hr class="soft"/>
                        </div>
                        <div class="tab-pane active" id="blockView">
                            <ul class="thumbnails">
                                @foreach ($relatedproduct as $product)

                                <li class="span3">
                                    <div class="thumbnail">
                                        <a href="{{url('product/'.$product['id'])}}"><img style="width:120px" src="{{ asset('storage/images/products_images/'.$product['main_image'] )}}" alt=""/></a>
                                        <div class="caption">
                                            <h5>{{$product['product_name']}}</h5>
                                            <p>
                                                {{$product['product_code']}}
                                            </p>
                                            <h4 style="text-align:center">
                                                 <a class="btn" href="{{ url('product/'.$product['id']) }}">Add to <i class="icon-shopping-cart"></i></a>
                                                 <?php $disprice = Product::getdiscountprice($product['id']) ?>
                                                 <a class="btn btn-primary" href="#">
                                                    @if($disprice > 0)
                                                        <del>Rs.{{$product['product_price']}}</del>
                                                    @else
                                                        Rs.{{$product['product_price']}}
                                                    @endif
                                                </a>
                                            </h4>
                                            @if($disprice > 0)
                                                <h4> Discounted price : Rs.{{$disprice}}</h4>
                                            @endif
                                        </div>
                                    </div>
                                </li>

                                @endforeach
                            </ul>
                            <hr class="soft"/>
                        </div>
                    </div>
                    <br class="clr">
                </div>
                <div class="tab-pane fade" id="rating">
                    <div id="mainBody">
                        <div class="container">

                            <div class="row">
                                <div class="span4">
                                    <h3> Write a Review </h3>
                                    <form method="post" action="{{url('add-rating')}}" class="form-horizontal">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$productdetail['id']}}" >
                                        <div class="rate" required="">
                                            <input type="radio" id="star5" name="rate" value="5" />
                                            <label for="star5" title="text">5 stars</label>
                                            <input type="radio" id="star4" name="rate" value="4" />
                                            <label for="star4" title="text">4 stars</label>
                                            <input type="radio" id="star3" name="rate" value="3" />
                                            <label for="star3" title="text">3 stars</label>
                                            <input type="radio" id="star2" name="rate" value="2" />
                                            <label for="star2" title="text">2 stars</label>
                                            <input type="radio" id="star1" name="rate" value="1" />
                                            <label for="star1" title="text">1 star</label>
                                          </div>
                                          <div class="control-group"></div>
                                          <div class="form-group">
                                            <label>Your Review</label>
                                            <textarea name="review" id="review" style="height: 50px; width:300px" required=""></textarea>

                                          </div>
                                          <div> &nbsp; </div>
                                          <div class="form-group">
                                              <input type="submit" name="Submit" class="btn btn-large btn-primary ">
                                          </div>
                                    </form>
                                </div>


                                <div class="span4">
                                <h3>Users Review</h3>
                                    @if(count($rating) > 0)
                                        @foreach ($rating as $rating1)
                                            <div>

                                                <?php
                                                    $count = 1;
                                                    while($count <= $rating1->ratings){ ?>
                                                        <span>&#9733;</span>
                                                    <?php $count++ ; }?>
                                                <p>{{$rating1->review}}</p>
                                                <p>By {{$rating1->name}}</p>
                                                <p>{{ date("d-m-Y",strtotime($rating1->created_at))}}</p>
                                                <hr>


                                            </div>
                                        @endforeach
                                    @else
                                        <p><b>Reviews are not available for this product!</b></p>
                                    @endif
                                </div>
                            </div>

                        </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection
