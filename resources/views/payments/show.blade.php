@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> <span class="float-right"><a href="/payments" class="btn btn-secondary">Go back</a></span></div>

                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">Name: {{$payment->name}}</li>
                        <li class="list-group-item">Email: {{$payment->email_address}}</li>
                        <li class="list-group-item">Money: {{$payment->amount}} {{$payment->currency}}</li>
                        <li class="list-group-item">Status: {{$payment->status}}</li>
                    </ul>
                    <hr>
                    <div class="card bg-light p-3">
                        Description:
                        {{$payment->description}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection