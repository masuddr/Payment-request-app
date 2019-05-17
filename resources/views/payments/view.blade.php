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
                                    <td><a href="payments/{{$payment->id}}">{{$payment->name}}</a></td>
                                    <td><a href="mailto:{{$payment->email_address}}">{{$payment->email_address}}</a></td>
                                    @if(Config::get('app.locale') == 'nl')
                                        <td>{{str_replace('.', ',', $payment->amount).' '. $payment->currency}}</td>
                                        @else
                                    <td>{{$payment->amount}} {{$payment->currency}}</td>
                                    @endif
                                    <td>{{$payment->status}}</td>
                                    <p id="{{$payment->id}}" style="display: none">{{$payment->payment_url}}</p>

                                        <td><button class="btn btn-primary" onclick="copyToClipboard('#{{$payment->id}}')">{{__('pagination.GetLink')}}</button></td>

                                    @if ($payment->paid_at != null)

                                    <td>@if(Config::get('app.locale') =='nl')
                                            {{ date('  d/m/Y H:i' , strtotime($payment->paid_at)) }}

                                    @else

                                            {{ date('  Y/m/d h:i A' , strtotime($payment->paid_at)) }}</td>
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
