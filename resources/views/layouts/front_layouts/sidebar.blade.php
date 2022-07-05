<?php
use App\Models\Section;
use App\Models\Product;
$sections = Section::sections();
?>
<div id="sidebar" class="span3">
    <div class="well well-small"><a id="myCart" href="{{ url('cart') }}"><img src="/images/front_user/ico-cart.png" alt="cart"><span class="totalcartitem"> {{totalCartItems()}} </span> Items in your cart</a></div>
    <ul id="sideManu" class="nav nav-tabs nav-stacked">
        @foreach ($sections as $section)
        @if(count($section) > 0)
        <li class="subMenu"><a>{{$section['name']}}</a>
            <ul>
                @foreach ($section['categories'] as $category)
                <li><a href="/{{$category['url']}}"><i class="icon-chevron-right"></i><strong>{{$category['category_name']}}</strong></a></li>
                @foreach ($category['subcategory'] as $subcategory)
                @php
                    $productCount = Product::productcount($subcategory['id']);
                @endphp
                <li><a href="/{{$subcategory['url']}}"><i class="icon-chevron-right"></i>{{$subcategory['category_name']}} ({{$productCount}})</a></li>
                @endforeach
                @endforeach
            </ul>
        </li>
        @endif
        @endforeach
    </ul>
    <br/>
    {{-- <div class="thumbnail">
        <img src="/images/front_user/payment_methods.png" title="Payment Methods" alt="Payments Methods">
        <div class="caption">
            <h5>Payment Methods</h5>
        </div>
    </div> --}}
</div>
