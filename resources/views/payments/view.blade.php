@extends('layouts.app')

@section('content')
    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            document.execCommand("copy");
        }
    </script>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard  <span class="float-right">
                        <a href="/payments/create" class="btn btn-success btn-sm">Create Payment</a>
                    </span></div>

                <div class="card-body">
                    <h3>Your Payments</h3>
                    @if(count($payments))
                        <table class="table table-striped">
                            <tr>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>URL</th>
                                <th></th>
                                <th></th>

                            </tr>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{$payment->amount}}</td>
                                    <td>{{$payment->status}}</td>
                                    <td><input type="text" readonly value="{{$payment->payment_url}}" id="myInput"></td>
                                      <td>  <button class="btn btn-primary" onclick="myFunction()">Get Link</button></td>
                                    <th>   <form action="{{ action('PaymentsController@destroy', $payment->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn-danger btn-sm float-right">Delete</button>
                                        </form>
                                    </th>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
