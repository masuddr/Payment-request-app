<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="{{ asset('js/stripe-form.js') }}"></script>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" >

    <title>Document</title>
</head>
<body>
<script src="https://js.stripe.com/v3/"></script>

<form action="/payment" method="post" id="payment-form">
    <div class="form-row inline">
        <div class="col">
            <label for="name">
                Name
            </label>
            <input id="name" name="name" placeholder="Jenny Rosen" required>
        </div>
        <div class="col">
            <label for="email">
                Email Address
            </label>
            <input id="email" name="email" type="email" placeholder="jenny.rosen@example.com" required>
        </div>
    </div>

    <div class="form-row">
        <label for="iban-element">
            IBAN
        </label>
        <div id="iban-element">
            <!-- A Stripe Element will be inserted here. -->
        </div>
    </div>
    <div id="bank-name"></div>

    <button>Submit Payment</button>

    <!-- Used to display form errors. -->
    <div id="card-errors" role="alert"></div>

    <!-- Display mandate acceptance text. -->
    <div id="mandate-acceptance">
        By providing your IBAN and confirming this payment, you are
        authorizing Rocketship Inc. and Stripe, our payment service
        provider, to send instructions to your bank to debit your account and
        your bank to debit your account in accordance with those instructions.
        You are entitled to a refund from your bank under the terms and
        conditions of your agreement with your bank. A refund must be claimed
        within 8 weeks starting from the date on which your account was debited.
    </div>
</form>

<script>
    // Create a Stripe client.
    // Note: this merchant has been set up for demo purposes.
    var stripe = Stripe('pk_test_G5G9sEyqMgDgPD5OYpiwKpC1');

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            },
            ':-webkit-autofill': {
                color: '#32325d',
            },
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a',
            ':-webkit-autofill': {
                color: '#fa755a',
            },
        }
    };

    // Create an instance of the iban Element.
    var card = elements.create('iban', {
        style: style,
        supportedCountries: ['SEPA'],
    });

    // Add an instance of the iban Element into the `iban-element` <div>.
    card.mount('#iban-element');

    //Send request to stripe and stripe will send back the token
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Create a token or display an error when the form is submitted.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();



        stripe.createToken(card, {
            // country and account_number are automatically populated from the IBAN Element.
            currency: 'eur',
            account_holder_name: 'Jenny Rosen',
            account_holder_type: 'individual',
        }).then(function(result) {
            if (result.error) {
                // Inform the customer that there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                stripeTokenHandler(result.token);
            }
        });
    });

    function stripeTokenHandler(token) {

        console.log(token);
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        //form.submit();
    }

</script>
</body>
</html>