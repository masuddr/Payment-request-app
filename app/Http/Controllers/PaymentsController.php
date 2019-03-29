<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mollie\Api;
use Mollie\Laravel\Facades\Mollie;
use App\User;
use App\BankAccount;
use App\Payment;

class PaymentsController extends Controller
{
    public function index()
    {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey('test_gGaGze4z6E2BcMhe5U6DQv5UhNu6Gq');

        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $payments = $user->payments;

        foreach($payments as $payment)
        {
            $requested = $mollie->payments->get($payment->mollie_id);
            $payment->status = $requested->status;
        }

        return view('payments.view', compact('payments'));
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
            "redirectUrl" => "https://668c6ca6.ngrok.io/payments/return.php?order_id={$orderId}",
            "webhookUrl" => "https://668c6ca6.ngrok.io/payments/webhook.blade.php",
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
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $banks = $user->bankaccounts;
        $banks_count = $user->bankaccounts->count();
        $bank = array('' => 'Select IBAN') + $banks->pluck('banking_number')->toArray();
        if ($banks_count == 0)
        {
            return redirect('transactions/create')->with('danger','You have no bank accounts. Please create one before attempting to create a payment.');
        }

        return view('payments.create',compact('bank'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey('test_gGaGze4z6E2BcMhe5U6DQv5UhNu6Gq');

        $orderId = time();

        $this->validate($request,['description' => 'required|max:15', 'amount' => 'digits_between:0.50,750']);

        $payment = $mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => number_format((float)$request['amount'], 2, '.', '') // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => $request->input('msg'),
            "redirectUrl" => "http://127.0.0.1:8000/payments",
            "webhookUrl" => "https://5db35498.ngrok.io/payments/webhook.blade.php",
            "metadata" => [
                "order_id" => $orderId,
            ],
            "issuer" => !empty($_POST["issuer"]) ? $_POST["issuer"] : null
        ]);

        $payment = $mollie->payments->get($payment->id);
        $user_id = auth()->user()->id;

        $pay = new Payment();
        $pay->mollie_id = $payment->id;
        $pay->amount = $payment->amount->value;
        $pay->currency = $payment->amount->currency;
        $pay->description = $request->input('description');
        $pay->status = $payment->status;
        $pay->payment_url = $payment->getCheckoutUrl();
        $pay->user_id = $user_id;
        $pay->save();

        return redirect('payments');

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
        $payment = Payment::find($id);
        $payment->delete();
        return redirect('payments')->with('success','Payment Deleted');
    }
}
