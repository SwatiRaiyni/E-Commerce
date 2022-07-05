<?php use App\Models\Product; ?>
@extends('layouts.front_layouts.layouts')
@section('content')
    <div class="span9">
        <div class="well well-small">
            <h4>Featured Products <small class="pull-right">{{ $featured }} featured products</small></h4>
            <div class="row-fluid">
                <div id="featured" @if ($featured > 4) class="carousel slide" @endif>
                    <div class="carousel-inner">
                        @foreach ($featureditemchunk as $key => $featureditem)
                            @if (count($featureditem) > 0)
                                <div class="item @if ($key == 1) active @endif">
                                    <ul class="thumbnails">
                                        @foreach ($featureditem as $item)
                                            <li class="span3">
                                                <div class="thumbnail">
                                                    <i class="tag"></i>
                                                    <a href="{{ url('product/'.$item['id']) }}"><img
                                                            src="/storage/images/products_images/{{ $item['main_image'] }}"
                                                            alt="" style="width:100px"></a>
                                                    <div class="caption">
                                                        <h5>{{ $item['product_name'] }}</h5>
                                                        <?php $disprice = Product::getdiscountprice($item['id']) ?>
                                                        <h4><a class="btn" href="{{ url('product/'.$item['id']) }}">VIEW</a>
                                                            <span class="pull-right" style="font-size:13px">
                                                                @if($disprice > 0)
                                                                    <del>Rs.{{$item['product_price']}}</del>
                                                                   <font color="red"> Rs.{{$disprice}}</font>
                                                                @else
                                                                    Rs.{{$item['product_price']}}
                                                                @endif </span></h4>

                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach


                    </div>
                    <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                    <a class="right carousel-control" href="#featured" data-slide="next">›</a>
                </div>
            </div>
        </div>
        <h4>Latest Products </h4>
        <ul class="thumbnails">
            @foreach ($getproduct as $product)
                <li class="span3">
                    <div class="thumbnail">


                        <a href="{{ url('product/'.$product['id']) }}"><img
                                src="/storage/images/products_images/{{ $product['main_image'] }}" alt=""
                                style="width:100px" /></a>
                        <div class="caption">
                            <h5>{{ $product['product_name'] }}</h5>
                            <p>
                                {{ $product['product_code'] }} ({{ $product['product_color'] }})
                            </p>

                            <h4 style="text-align:center">
                                    {{-- <a class="btn" href="{{ url('product/'.$product['id']) }}"> <i
                                        class="icon-zoom-in"></i>
                                    </a>--}}
                                    <a class="btn" href="{{ url('product/'.$product['id']) }}">Add to <i
                                        class="icon-shopping-cart"></i>
                                    </a>
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
    </div>
@endsection
