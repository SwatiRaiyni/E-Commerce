<html>
    <head>
        <style>
            body {
              display: flex;
              direction: 'column';
            }

            .column {
              border: 1px solid #ccc;
              margin: 20px;
              padding: 20px;
            }

            p {
              text-align: center;
              margin-bottom: 50px;
            }

          </style>
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <body>
        <script src="https://www.paypal.com/sdk/js?client-id=AdWwTsGKZw8xr-oa2IsRuetL2eRrSctwQqnnbbMRhTll0Hvc8h2ZH1Ft5a6lonCYZdP1Xsb8LmBgDsIa&vault=true&intent=subscription"></script>
        {{-- @foreach ($plandata as $plandata1)
        <div class="column">
            <p>
              {{$plandata1->planname}} <br />${{$plandata1->Amount}} per month
            </p>
            <a  href="/changesubnew/{{$id}}/{{$plandata1->planid}}"  class="btn btn-primary">Change Subscription</a> Using curl to php <br /><br/>
            <a  href="javascript:void(0)"  class="updateplan btn btn-primary" plan_id="{{$plandata1->planid}}" s_id="{{$id}}" >Change Subscription</a> Using ajax <br />
        </div>
        @endforeach --}}
        @foreach ($plandata as $plandata1)
        <div class="column">
            <p>
                {{$plandata1->planname}} <br />${{$plandata1->Amount}} per month
            </p>
            <div id="paypal-button-container-{{$plandata1->planid}}"></div>
        </div>
        <script>
        paypal.Buttons({
            createSubscription: function(data, actions) {
                return actions.subscription.revise('{{$id}}', {
                    'plan_id': '{{$plandata1->planid}}'

                });
            },
            onApprove: function(data, actions) {
                swal({
                    title: "Good job!",
                    text: "Your subscription changed successfully! Your subscription Id is:"+data.subscriptionID,
                    icon: "success",
                    button: "done!",
                });
                change(data,'{{$plandata1->planname}}','{{$plandata1->Amount}}');
            }
          }).render('#paypal-button-container-{{$plandata1->planid}}');
        </script>
        @endforeach
    </body>

    <script>
        function change(data,planname,amount){

              $.ajax({
                type:'POST',
                url:'/changedata',
                data:{
                    s_id:data.subscriptionID,
                    token : data.facilitatorAccessToken,
                    planname:planname,
                    amount:amount
                },
                success:function(data){
                    console.log(data);
                    window.location.href="/subscriptionnew";
                },error:function(){
                    alert("Erorr");
                }
            });
        }
        </script>

    <script>
        accesstoken();
        function accesstoken(){

            var url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";

            var xhr = new XMLHttpRequest();
            xhr.open("POST", url);

            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.setRequestHeader("Authorization", "Basic QWRXd1RzR0tadzh4ci1vYTJJc1J1ZXRMMmVSclNjdHdRcW5uYmJNUmhUbGwwSHZjOGgyWkgxRnQ1YTZsb25DWVpkUDFYc2I4TG1CZ0RzSWE6RUtwdmZVY3BXQnRYWjFHWHdqeFZPTEw4VGlWNlpqVXZGcXNsaEdUWGszbWJzZk5EWnVvQXlQaFZ2Sk13WU9IMTFVMy1semZJWWpzY0E3VlM=");

            xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                // console.log(xhr.status);
                // console.log(xhr.responseText);
                var res = xhr.responseText;

                var data1 = res.split(',');
                var data2 = data1[1].split(':');

                var token = data2[1];
                var token = token.slice(1, -1);
               // console.log(token);
                sessionStorage.setItem("token",token);
              //  console.log(token);

            }};

            var data = "grant_type=client_credentials";

            xhr.send(data);

        }
            $(".updateplan").click(function(){
             var pid =  $(this).attr("plan_id");
             var sid = $(this).attr("s_id");
             var token = sessionStorage.getItem("token"); console.log(token);

            var url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/"+sid+"/revise";

            var xhr = new XMLHttpRequest();
            xhr.open("POST", url);

            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.setRequestHeader("Authorization", "Bearer "+token);

            xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                console.log(xhr.status);
                console.log(xhr.responseText);
            }};

            var data = `{
            "plan_id": "P-6WT24152Y78398832MKTSXSI",
            "effective_time" :"2022-07-01T00:00:00Z",
            "shipping_amount": {
                "currency_code": "USD",
                "value": "10.00"
            },
            "shipping_address": {
                "name": {
                "full_name": "John Doe"
                },
                "address": {
                "address_line_1": "2211 N First Street",
                "address_line_2": "Building 17",
                "admin_area_2": "San Jose",
                "admin_area_1": "CA",
                "postal_code": "95131",
                "country_code": "US"
                }
            },
            "application_context": {
                "brand_name": "walmart",
                "locale": "en-US",
                "shipping_preference": "SET_PROVIDED_ADDRESS",
                "payment_method": {
                "payer_selected": "PAYPAL",
                "payee_preferred": "IMMEDIATE_PAYMENT_REQUIRED"
                }

            }
            }`;

            xhr.send(data);

            });
    </script>
</html>
