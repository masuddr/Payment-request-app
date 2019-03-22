@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Transaction <span class="float-right"><a href="/home" class="btn btn-secondary">Go back</a></span></div>

                <div class="card-body">
                    <form action="{{ action('TransactionsController@store') }}" method="post">
                        {{ csrf_field() }}
                        <input type="text" name="name" class="form-control" placeholder="Name">
                        <input type="text" name="iban" class="form-control" placeholder="IBAN">
                        <button type="submit" class="btn-success">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection