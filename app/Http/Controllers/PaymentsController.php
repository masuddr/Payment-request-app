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
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $payments = $user->payments;

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
            return view('transactions.create')->with('danger','You have no bank accounts. Please create one before attempting to create a payment.');
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
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $banks = $user->bankaccounts;



       return $banks[$request->get('banking_number')]->banking_number;




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
        return redirect('/home')->with('success','Payment Deleted');
    }
}
