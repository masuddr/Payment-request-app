<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\User;
use App\BankAccount;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $banks = $user->bankaccounts;

        return view('transactions.view',compact('banks'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Valdiation
        $this->validate($request,['iban' => 'iban']);
        $this->validate($request,['name' => 'required','iban' => 'required']);

        $bank = new BankAccount();
        $bank->name = $request->input('name');
        $bank->banking_number = strtoupper($request->input('iban'));
        $bank->user_id = auth()->user()->id;

        $bank->save();

        return redirect('/home')->with('success','Transaction Added');

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



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = BankAccount::find($id);
        $bank->delete();
        return redirect('/home')->with('danger','Transaction Deleted');
    }
}
