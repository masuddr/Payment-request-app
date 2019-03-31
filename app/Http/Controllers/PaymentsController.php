<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mollie\Api;
use Mollie\Laravel\Facades\Mollie;
use App\User;
use App\BankAccount;
use App\Payment;
use Illuminate\Support\Facades\Input;


class PaymentsController extends Controller
{
    public function index()
    {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey('test_gGaGze4z6E2BcMhe5U6DQv5UhNu6Gq');

        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $payments =$user->payments;


        $banks = $user->bankaccounts;
        $banksArray = $user->bankaccounts;
        foreach($payments as $payment)
        {

            $requested = $mollie->payments->get($payment->mollie_id);
            $payment->status = $requested->status;

            foreach ($banksArray as $bank)
            {
                if ($payment->banking_number == $bank->banking_number)
                {
                    if ($payment->status == "paid")
                    {
                        if ($payment->paid_at == '')
                        {
                            $payment->paid_at = date("Y/m/d h:i");
                            $amount = $this->convertCurrency($payment->amount,$payment->currency,$bank->currency);
                            $bank->balance+=$amount;
                            $bank->save();
                            $payment->save();
                        }
                    }
                }
            }
        }

        return view('payments.view', compact('payments'));
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

        $currencies = ['EUR', 'USD', 'GBP'];

        return view('payments.create',compact('bank','currencies'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function convertCurrency($amount,$from_currency,$to_currency){
        $apikey = '84be6bf5b226e2d49dc1';

        $from_Currency = urlencode($from_currency);
        $to_Currency = urlencode($to_currency);
        $query =  "{$from_Currency}_{$to_Currency}";

        $json = file_get_contents("https://free.currencyconverterapi.com/api/v6/convert?q={$query}&compact=ultra&apiKey={$apikey}");
        $obj = json_decode($json, true);

        $val = floatval($obj["$query"]);


        $total = $val * $amount;
        return $total;
    }

    public function store(Request $request)
    {
        $this->validate($request,['description' => 'required|max:15','amount' => 'numeric|min:0.01', 'email' => 'email']);
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $banks = $user->bankaccounts;
        $banksArray = array('' => 'Select IBAN') + $banks->pluck('banking_number')->toArray();
        if($banksArray[Input::get('banking_number')] == "Select IBAN"){
            return redirect('payments/create')->with('danger','Please select a valid IBAN');
        }
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey('test_gGaGze4z6E2BcMhe5U6DQv5UhNu6Gq');
        $currencies = ["EUR", "USD", "GBP"];
        $cur = Input::get('currency');
        $orderId = time();
        $currency = $currencies[$cur];
        $tempAmount = 0.01;


        if($currency == "USD"){
          $tempAmount = $this->convertCurrency(number_format((float)$request['amount'], 2, '.', ''),'USD','EUR');
        }else if ($currency == 'GBP'){
            $tempAmount = $this->convertCurrency(number_format((float)$request['amount'], 2, '.', ''),'GBP','EUR');
        } else{
            $tempAmount = number_format((float)$request['amount'], 2, '.', '');
        }

        $payment = $mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => number_format((float)$tempAmount, 2, '.', '') // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => $request->input('description'),
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
        $pay->amount =  number_format((float)$request->input('amount'), 2, '.', '');
        $pay->currency = $currency;
        $pay->description = $request->input('description');
        $pay->status = $payment->status;
        $pay->payment_url = $payment->getCheckoutUrl();
        $pay->banking_number = $banksArray[Input::get('banking_number')];
        $pay->name = $request->input('name');
        $pay->email_address = $request->input('email');
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
        $payment = Payment::find($id);
        return view('payments.show',compact('payment'));
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
