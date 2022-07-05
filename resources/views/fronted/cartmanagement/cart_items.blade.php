<?php
use App\Models\Product;
?>
<table class="table table-bordered">
    <thead>
      <tr>
        <th>Product</th>
        <th colspan="2">Description</th>
        <th>Quantity/Update</th>
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
          <div class="input-append">
              <input class="span1" style="max-width:34px" value="{{$item['quantity']}}" id="appendedInputButtons" size="16" type="text">
                  <button class="btn btnItemUpdate qtyMinus" type="button" data-cartid = "{{ $item['id']}}">
                      <i class="icon-minus"></i>
                  </button>
                  <button class="btn btnItemUpdate qtyPlus" type="button" data-cartid = "{{ $item['id']}}">
                      <i class="icon-plus"></i></button>
                  <button class="btn btn-danger btnItemDelete" type="button" data-cartid = "{{ $item['id']}}">
                      <i class="icon-remove icon-white"></i>
                  </button>
          </div>
        </td>
        <td>Rs. {{$productattrprice['product_price'] * $item['quantity']}}</td>
        <td>Rs. {{$productattrprice['discount'] * $item['quantity']}}</td>
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
          <td class="label label-important" style="display:block"> <strong> Rs.{{$total_price}}</strong></td>
        </tr>


      </tbody>
</table>
