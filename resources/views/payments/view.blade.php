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
                                <th>{{__('pagination.Name')}}</th>
                                <th>{{__('pagination.Email')}}</th>
                                <th>{{__('pagination.Amount')}}</th>
                                <th>{{__('pagination.Status')}}</th>
                                <th>{{__('pagination.URL')}}</th>
                                <th>{{__('pagination.PaidAt')}}</th>
                            </tr>

                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{$payment->name}}</td>
                                    <td>{{$payment->email_address}}</td>
                                    <td>{{$payment->amount}} {{$payment->currency}}</td>
                                    <td>{{$payment->status}}</td>
                                    <p id="{{$payment->id}}" style="display: none">{{$payment->payment_url}}</p>
                                    <td><button class="btn btn-primary" onclick="copyToClipboard('#{{$payment->id}}')">Get Link</button></td>

                                        
                                    @if ($payment->paid_at != null)

                                    <td>@if(Config::get('app.locale') =='en')
                                            {{ Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d H:i') }}

                                    @else
                                     {{ Carbon\Carbon::parse($payment->paid_at)->format('d-m-Y H:i') }}</td>
                                    @endif

                                    @endif
                                    <th>   <form action="{{ action('PaymentsController@destroy', $payment->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <input name="_method" type="hidden" value="DELETE">
                                            @if ($payment->status == 'paid')

                                            @else
                                            <button type="submit" class="btn-danger btn-sm float-right">{{__('pagination.Delete')}}</button>
                                            @endif
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
