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
   <div class="column">
    <p> To change subscription plan please cancel this subscription</p>
    @foreach ($listsub as $listsub1)


        <p>
          {{$listsub1->subscription_plan}} <br />Amount:${{$listsub1->amount}} per month<br/> Duration:{{$listsub1->duration}} Month <br/> SubscriptionId: {{$listsub1->subscription_id}}
        </p>

       <p> <a  href="/cancelsub/{{$listsub1->subscription_id}}" class="cancel btn btn-danger">Cancel Subscription</a></p><br/>
       <p> <a  href="/changesub/{{$listsub1->subscription_id}}" class="changesub btn btn-primary">Change Subscription</a></p>
    </div>

    @endforeach

