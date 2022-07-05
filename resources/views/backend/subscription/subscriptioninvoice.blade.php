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
                        <strong>Status: {{$result->status}}</strong><br>
    				<strong>Billed To:</strong><br>
    					{{$userdetails['name']}}<br>
                        {{$userdetails['email']}}<br>
    					{{$userdetails['phone']}}<br>
                        <strong>Payer id:</strong><br>
    					{{ $result->subscriber->payer_id}}<br>
                        <strong>Subscriber id:</strong><br>
    					{{$result->id}}<br>

    				</address>
    			</div>
                <div class="col-xs-6 text-right">
    				<address>
    					<strong>Subscription Date:</strong><br>
    					{{date('d-m-Y',strtotime($orderdetails['subscribed_at']))}}<br><br>
                        <strong>Address:</strong><br>
    					{{$result->subscriber->shipping_address->address->address_line_1}}<br>
                        {{$result->subscriber->shipping_address->address->admin_area_2}}<br>
    					{{$result->subscriber->shipping_address->address->postal_code}}<br>
    				</address>
    			</div>
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Subscription summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
                                    <td><strong>Planid</strong></td>
                                    <td><strong>plan name</strong></td>
                                    <td><strong>plan Duration</strong></td>
        							<td><strong>Total</strong></td>
                                </tr>
    						</thead>
    						<tbody>
                            <tr>
                                <td>{{$result->plan_id}}</td>
                                <td>{{$orderdetails['subscription_plan']}}</td>
                                <td> {{$orderdetails['duration']}}</td>
                                <td>USD {{$orderdetails['amount']}}</td>
                            </tr>
                            <tr>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line text-right"><strong>Subtotal:</strong></td>
                                <td class="thick-line ">USD {{$orderdetails['amount']}}</td>
                            </tr>

                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-right"><strong>Total:</strong></td>
                                <td class="no-line ">USD {{$orderdetails['amount']}}</td>
                            </tr>

                        </tbody>
                    </table>



    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
