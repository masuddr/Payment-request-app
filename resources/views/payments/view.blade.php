@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <h3>Your Payments</h3>
                    @if(count($payments))
                        <table class="table table-striped">
                            <tr>
                                <th>Amount</th>
                                <th>Status</th>
                                <th></th>

                            </tr>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{$payment->amount}}</td>
                                    <td>{{$payment->status}}</td>
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
