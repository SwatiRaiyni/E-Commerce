<!DOCTYPE html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>

<script src="https://www.paypal.com/sdk/js?client-id=AdWwTsGKZw8xr-oa2IsRuetL2eRrSctwQqnnbbMRhTll0Hvc8h2ZH1Ft5a6lonCYZdP1Xsb8LmBgDsIa&vault=true&intent=subscription"></script>
<div class="column">
    <p>
      New <br />$1 per month
    </p>
<div id="paypal-button-container-P-90H178758V777402AMKQXNQY"></div>
</div>
<script>
  paypal.Buttons({

      createSubscription: function(data, actions) {
        return actions.subscription.create({
          /* Creates the subscription */
          plan_id: 'P-90H178758V777402AMKQXNQY'
        });
      },
      onApprove: function(data, actions) {
        //alert(data); // You can add optional success message for the subscriber here
       //console.log(data);
       swal({
            title: "Good job!",
            text: "You Subscribed successfully! Your subscription Id is:"+data.subscriptionID,
            icon: "success",
            button: "done!",
        });
      // window.location.href = "http://localhost:8000/subscription";
    //   console.log(actions);
      }
  }).render('#paypal-button-container-P-90H178758V777402AMKQXNQY'); // Renders the PayPal button
</script>

{{--
<script src="https://www.paypal.com/sdk/js?client-id=AdWwTsGKZw8xr-oa2IsRuetL2eRrSctwQqnnbbMRhTll0Hvc8h2ZH1Ft5a6lonCYZdP1Xsb8LmBgDsIa&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script> --}}

<div class="column">
    <p>
      Dimond<br />$5 per month
    </p>
  <div id="paypal-button-container-P-6LF78704YL2976336MKQY5MA"></div>
</div>
<script>
  paypal.Buttons({
      style: {
          shape: 'rect',
          color: 'gold',
          layout: 'vertical',
          label: 'subscribe'
      },
      createSubscription: function(data, actions) {
        return actions.subscription.create({
          /* Creates the subscription */
          plan_id: 'P-6LF78704YL2976336MKQY5MA'
        });
      },
      onApprove: function(data, actions) { console.log(data);
       // alert(data.subscriptionID); // You can add optional success message for the subscriber here
       swal({
            title: "Good job!",
            text: "You Subscribed successfully! Your subscription Id is:"+data.subscriptionID,
            icon: "success",
            button: "done!",
        });
      }
  }).render('#paypal-button-container-P-6LF78704YL2976336MKQY5MA'); // Renders the PayPal button
</script>




<div class="column">
    <p>
      Premium<br />$10 per month
    </p>
    <div id="paypal-button-container-P-2X6512082U131874PMKQ3GLY"></div>
</div>


{{-- <script src="https://www.paypal.com/sdk/js?client-id=AdWwTsGKZw8xr-oa2IsRuetL2eRrSctwQqnnbbMRhTll0Hvc8h2ZH1Ft5a6lonCYZdP1Xsb8LmBgDsIa&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script> --}}
<script>
  paypal.Buttons({
      style: {
          shape: 'rect',
          color: 'gold',
          layout: 'vertical',
          label: 'subscribe'
      },
      createSubscription: function(data, actions) {
        return actions.subscription.create({
          /* Creates the subscription */
          plan_id: 'P-2X6512082U131874PMKQ3GLY'
        });
      },
      onApprove: function(data, actions) {
        //alert(data.subscriptionID); // You can add optional success message for the subscriber here
        swal({
            title: "Good job!",
            text: "You Subscribed successfully! Your subscription Id is:"+data.subscriptionID,
            icon: "success",
            button: "done!",
        });
      }
  }).render('#paypal-button-container-P-2X6512082U131874PMKQ3GLY'); // Renders the PayPal button
</script>





