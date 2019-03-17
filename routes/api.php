<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/payment', function () {
    // Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
    \Stripe\Stripe::setApiKey("sk_test_1PLuZyXG7mggzJSAHa5596Op");

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
    $token = $_POST['stripeSource'];
    $charge = \Stripe\Charge::create([
        "amount" => 50,
        "currency" => "eur",
        "source" => $token,
    ]);
    dd('payment succeeded');
});

Route::post('invoice', function(){
    // Set your secret key: remember to change this to your live secret key in production
    // See your keys here: https://dashboard.stripe.com/account/apikeys
    \Stripe\Stripe::setApiKey("sk_test_1PLuZyXG7mggzJSAHa5596Op");

    \Stripe\Customer::create([
        "description" => "Customer for jenny.rosen@example.com",
        "source" => "stripeSource" // obtained with Stripe.js
    ]);

    \Stripe\InvoiceItem::create([
        'amount' => 50,
        'currency' => 'eur',
        'customer' => 'cus_4fdAW5ftNQow1a',
        'description' => 'Test invoice number 1',
    ]);
});
