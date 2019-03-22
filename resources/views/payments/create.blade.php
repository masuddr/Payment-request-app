@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Payment <span class="float-right"><a href="/home" class="btn btn-secondary">Go back</a></span></div>

                <div class="card-body">
                    {{ Form::open(array('action' => 'PaymentsController/store')) }}
                     {{Form::select('size', array('L' => 'Large', 'S' => 'Small'))}}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection