<!DOCTYPE html>
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
  <script src="https://www.paypal.com/sdk/js?client-id=AdWwTsGKZw8xr-oa2IsRuetL2eRrSctwQqnnbbMRhTll0Hvc8h2ZH1Ft5a6lonCYZdP1Xsb8LmBgDsIa&vault=true&intent=subscription">
  </script>

    @if(count($subdata) == 0)
    @foreach ($data as $data1)

    <div class="column">
        <p>
          {{$data1->planname}} <br />${{$data1->Amount}} per month
        </p>
    <div id="paypal-button-container-{{$data1->planid}}"></div>
    </div>
    <script>

      paypal.Buttons({
        createSubscription: function(data, actions) {
          return actions.subscription.create({
            'plan_id': '{{$data1->planid}}' // Creates the subscription
          });
        },
        onApprove: function(data, actions) {
          console.log(data);
          console.log(actions);
          swal({
            title: "Good job!",
            text: "You Subscribed successfully! Your subscription Id is:"+data.subscriptionID,
            icon: "success",
            button: "done!",
            });
            save(data,'{{$data1->planname}}','{{$data1->Amount}}');
        }
        }).render('#paypal-button-container-{{$data1->planid}}');


    </script>
    @endforeach
    @else

    <div class="column">
    @php
       // dd($result);
    @endphp

    <p>You have Already subscribe</p>
    <p><b>Details:</b></p>
    <p>Status:{{$result->status}}</p>
    <p>Subscription_id :{{$result->id}}</p>
    <p>plan_id :{{$result->plan_id}}</p>
    <p><b>last pament:</b></p>
    <p>Amount: {{$result->billing_info->last_payment->amount->value}}</p>
    <p>currency_code: {{$result->billing_info->last_payment->amount->currency_code}}</p>
    <p> Next billing time :{{ date("d-m-Y",strtotime($result->billing_info->next_billing_time))}}</p>
    <p><b>Customer detail</b></p>
    <p> Email:{{$result->subscriber->email_address}}</p>
    <p>Address:{{$result->subscriber->shipping_address->address->address_line_1}}
        {{$result->subscriber->shipping_address->address->admin_area_2}}</p>
    <p>Pincode:{{$result->subscriber->shipping_address->address->postal_code}}</p>

    <p><a href="/listsub" class="btn btn-primary">Action</a></p>
    </div>
    @endif

      <script>
        function save(data,planname,amount){

              $.ajax({
                type:'POST',
                url:'/savedata',
                data:{
                    s_id:data.subscriptionID,
                    token : data.facilitatorAccessToken,
                    planname:planname,
                    amount:amount
                },
                success:function(data){
                    console.log(data);
                    window.location.href="/listsub";
                },error:function(){
                    alert("Erorr");
                }
            });
        }
        </script>
  </body>
</html>
