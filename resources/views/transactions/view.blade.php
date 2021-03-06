@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard<span class="float-right"><a href="/transactions/create" class="btn btn-success btn-sm">{{__('pagination.createbankaccount')}}</a></span></div>

                <div class="card-body">
                    <h3>{{__('pagination.yourbankaccounts')}}</h3>
                    @if(count($banks))
                        <table class="table table-striped">
                            <tr>
                                <th>IBAN</th>
                                <th>{{__('pagination.Balance')}}</th>
                                <th></th>

                            </tr>
                            @foreach($banks as $bank)
                                <tr>
                                    <td>{{$bank->banking_number}}</td>
                                    @if(Config::get('app.locale') == 'nl')
                                        <td>{{str_replace('.', ',', $bank->balance).' '. $bank->currency}}</td>
                                    @else
                                        <td>{{$bank->balance}} {{$bank->currency}}</td>
                                    @endif
                                    <th>   <form action="{{ action('TransactionsController@destroy', $bank->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn-danger btn-sm float-right">{{__('pagination.Delete')}}</button>
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
