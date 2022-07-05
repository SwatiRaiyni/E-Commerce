<html>
    <body>
        <table style=width:700px">
            <tr><td>&nbsp;</td></tr>
            <tr><td>Hello {{$name}},</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Thanks you for shopping with us. Your order details are as below: </td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Order no:{{$order_id}}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>
                <table style="95%" cellpadding="5" cellspacing="5">
                    <tr>
                        <td>Product Name</td>
                        <td>Product code</td>
                        <td>Product size</td>
                        <td>Product color</td>
                        <td>Product Quantity</td>
                        <td>Product Price</td>

                    </tr>
                    @foreach ($orderdetails['orderproduct'] as $order)

                    <tr>
                        <td>{{$order['product_name']}}</td>
                        <td>{{$order['product_code']}}</td>
                        <td>{{$order['product_size']}}</td>
                        <td>{{$order['product_color']}}</td>
                        <td>{{$order['product_qty']}}</td>
                        <td>{{$order['product_price']}}</td>

                    </tr>

                    @endforeach
                    <tr>
                        <td colspan="5" align="right">Total</td>
                        <td>{{$orderdetails['grand_total']}}
                    </tr>
                </table>
                </td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td>
                        <strong>Delivery Address</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        {{$orderdetails['name']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{$orderdetails['address']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{$orderdetails['pincode']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{$orderdetails['mobile']}}
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>For any query you can contact us</td></tr>
        </table>
    </body>
</html>
