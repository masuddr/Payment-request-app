<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+
      a5WDVnPi21kFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" >

    <script src="https://js.stripe.com/v3/"></script>
    <title>Document</title>
</head>
<body>
<h1>Make your payment</h1>





             <form action="/payment" method="post" id="payment-form">
                 <div class="form-row">
                     <label for="card-element">
                         Credit or debit card
                     </label>
                     <div id="card-element">
                         <!-- A Stripe Element will be inserted here. -->
                     </div>

                     <!-- Used to display form errors. -->
                     <div id="card-errors" role="alert"></div>
                 </div>

                 <button>Submit Payment</button>
             </form>





<script>
    var stripe = Stripe('pk_test_G5G9sEyqMgDgPD5OYpiwKpC1');
    var elements = stripe.elements();

    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');
</script>
</body>
</html>