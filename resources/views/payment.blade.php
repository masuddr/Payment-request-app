<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" >

    <script src="https://js.stripe.com/v3/"></script>
    <title>Document</title>
</head>
<body>
<h1>Make your payment</h1>
<script>
    var stripe = Stripe('pk_test_G5G9sEyqMgDgPD5OYpiwKpC1');
    var elements = stripe.elements();
</script>

<form action="/charge" method="post" id="payment-form">
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
    <div id="error-message" role="alert"></div>

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
</body>
</html>