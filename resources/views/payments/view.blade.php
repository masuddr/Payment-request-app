@extends('layouts.app')

@section('content')
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
        }
    </script>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard  <span class="float-right">
                        <a href="/payments/create" class="btn btn-success btn-sm">{{__('pagination.CreatePayment')}}</a>
                    </span></div>

                <div class="card-body">
                    <h3>{{__('pagination.yourpayments')}}</h3>
                    @if(count($payments))
                        <table class="table table-striped">
                            <tr>

                                <th>Amount</th>
                                <th>Status</th>
                                <th>URL</th>
                                <th>Paid At</th>
                                <th></th>
                                <th></th>

                            </tr>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{$payment->amount}} {{$payment->currency}}</td>
                                    <td>{{$payment->status}}</td>
                                    <p id="{{$payment->id}}" style="display: none">{{$payment->payment_url}}</p>
                                    <td><button class="btn btn-primary" onclick="copyToClipboard('#{{$payment->id}}')">Get Link</button></td>
                                    <td>{{$payment->paid_at}}</td>
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
