<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mollie\Api;
use Mollie\Laravel\Facades\Mollie;

class PaymentsController extends Controller
{
    public function index()
    {

    }

    public function preparePayment()
    {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey('test_gGaGze4z6E2BcMhe5U6DQv5UhNu6Gq');
        $method = $mollie->methods->get(\Mollie\Api\Types\PaymentMethod::IDEAL, ["include" => "issuers"]);

        return view('molliepayment', compact('method'));
    }

    public function pay(Request $request){
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey('test_gGaGze4z6E2BcMhe5U6DQv5UhNu6Gq');

        $orderId = time();

        $payment = $mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => number_format((float)$request['amount'], 2, '.', '') // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Order #{$orderId}",
            "redirectUrl" => "https://5d8370a7.ngrok.io/payments/return.php?order_id={$orderId}",
            "webhookUrl" => "https://26af5ca6.ngrok.io/payments/webhook.blade.php",
            "metadata" => [
                "order_id" => $orderId,
            ],
            "issuer" => !empty($_POST["issuer"]) ? $_POST["issuer"] : null
        ]);

        $url = $payment->getCheckoutUrl();
        return redirect($url);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
