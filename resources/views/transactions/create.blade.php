@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create bank account <span class="float-right"><a href="/home" class="btn btn-secondary">Go back</a></span></div>

                <div class="card-body">
                    {{ Form::open(array('action' => 'PaymentsController@store')) }}
                    {{--{{ method_field('HEAD') }}--}}
                    <div class="form-group">
                        {{ Form::select('currency', $currencies, null, ['class'=>'form-control']) }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('iban', 'IBAN') !!}
                        {!! Form::text('iban', null, ['class' => 'form-control']) !!}
                    </div>
                    {{Form::submit('Create bank account',['class' => 'btn-primary'])}}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection