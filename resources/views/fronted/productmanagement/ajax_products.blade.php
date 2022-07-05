<?php use App\Models\Product; ?>
<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach ($categoryproduct as $product)


        <li class="span3">
            <div class="thumbnail" style="height:260px">
                <a href="{{ url('product/'.$product['id'])}}"><img src="/storage/images/products_images/{{ $product['main_image'] }}" alt="" style="width:80px"/></a>
                <div class="caption">
                    <h5>{{$product['product_name']}} </h5>
                    <p>
                        {{$product['description']}}
                    </p>
                    <?php $disprice = Product::getdiscountprice($product['id']) ?>
                    <h4 style="text-align:center">
                        {{-- <a class="btn" href="{{ url('product'.$product['id'])}}"> <i class="icon-zoom-in"></i></a> --}}
                        <a class="btn" href="{{ url('product/'.$product['id'])}}">Add to <i class="icon-shopping-cart"></i></a>
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
