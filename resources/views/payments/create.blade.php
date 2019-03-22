@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Payment <span class="float-right"><a href="/home" class="btn btn-secondary">Go back</a></span></div>

                <div class="card-body">
                    {{ Form::open(array('action' => 'PaymentsController@store')) }}
                    {{--{{ method_field('HEAD') }}--}}
                    <div class="form-group">
                        {!! Form::label('name', 'Your Name') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'E-mail Address') !!}
                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('amount', 'Amount') !!}
                        {!! Form::number('amount', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {{ Form::select('banking_number', $bank, null, ['class'=>'form-control']) }}

                    </div>
                    <div class="form-group">
                        {!! Form::textarea('msg', null, ['class' => 'form-control']) !!}
                    </div>


                    <br>
                    {{Form::submit('Send Payment',['class' => 'btn-primary'])}}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection