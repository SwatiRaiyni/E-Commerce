<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice</h2>
                <h3 class="pull-right">Order # {{$orderdetails['id']}}</h3>
                <br>
                <span class="pull-right">

                    <?php echo DNS1D::getBarcodeHTML($orderdetails['id'], 'C39'); ?>
                </span><br>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Billed To:</strong><br>
    					{{$userdetails['name']}}<br>
                        {{$userdetails['email']}}<br>
    					{{$userdetails['phone']}}<br>

    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Shipped To:</strong><br>
                    {{$orderdetails['name']}}<br>
                    {{$orderdetails['address']}}<br>
                    {{$orderdetails['pincode']}}<br>
                    {{$orderdetails['mobile']}}<br>
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    					{{$orderdetails['payment_method']}}<br>

    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Order Date:</strong><br>
    					{{date('d-m-Y',strtotime($orderdetails['created_at']))}}<br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Item</strong></td>
        							<td class="text-center"><strong>Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
                                @php
                                    $subTotal = 0;
                                @endphp
    						@foreach ($orderdetails['orderproduct'] as $product)
                            <tr>
                                <td>
                                    Name:{{$product['product_name']}}<br>
                                    Size:{{$product['product_size']}}<br>
                                    Code:{{$product['product_code']}}<br>
                                    Color:{{$product['product_color']}}<br>
                                     <?php echo DNS1D::getBarcodeHTML($orderdetails['id'], 'C39'); ?>
                                </td>
                                <td class="text-center"> Price: ${{$product['product_price']}}</td>
                                <td class="text-center">Quntity :{{$product['product_qty']}}</td>
                                <td class="text-right">USD {{$product['product_price'] * $product['product_qty']}} </td>
                            </tr>
                            @php
                                $subTotal = $subTotal + ($product['product_price'] * $product['product_qty'])
                            @endphp
                            @endforeach
                            <tr>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                <td class="thick-line text-right">USD {{$subTotal}}</td>
                            </tr>

                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-center"><strong>Total</strong></td>
                                <td class="no-line text-right">USD {{$subTotal}}</td>
                            </tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
