<html>
    <head>
        <title>

        </title>
    </head>
    <body>
        <table>
            <tr>
                <td>Dear {{$details['name']}}!
                </td>
            </tr>
            <tr>
                <td>Your return request for order no.{{$details['order_id']}} with status {{$details['return_status']}}
                </td>
            </tr>
            <tr>
                <td>&nbsp;
                </td>
            </tr>
            <tr>
                <td>
                    Name: {{$details['name']}}
                </td>
            </tr>
            <tr>
                <td>&nbsp;
                </td>
            </tr>
            <tr>
                <td>
                    Thanks and regards
                </td>
            </tr>
            <tr>
                <td>
                    Ecommerce website
                </td>
            </tr>
        </table>
    </body>
</html>
