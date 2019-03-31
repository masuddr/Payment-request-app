@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> <span class="float-right"><a href="/payments" class="btn btn-secondary">{{__('pagination.GoBack')}}</a></span></div>

                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">{{__('pagination.Name')}}: {{$payment->name}}</li>
                        <li class="list-group-item">{{__('pagination.Email')}}: {{$payment->email_address}}</li>
                        <li class="list-group-item">{{__('pagination.Amount')}}: {{$payment->amount}} {{$payment->currency}}</li>
                        <li class="list-group-item">{{__('pagination.Status')}}: {{$payment->status}}</li>
                    </ul>
                    <hr>
                    <div class="card bg-light p-3">
                        {{__('pagination.Description')}}:
                        {{$payment->description}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection