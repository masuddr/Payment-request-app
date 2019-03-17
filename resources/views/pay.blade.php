<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}" />

    {{--<script type="text/javascript" src="../../js/charge.js"></script>--}}


    <title>Pay Me</title>
</head>
<body>

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
</form>
<script src="https://js.stripe.com/v3/"></script>
<script src="{{asset('../../js/charge.js')}}"></script>
</body>
</html>