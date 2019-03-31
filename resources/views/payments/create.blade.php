@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('pagination.CreatePayment')}}<span class="float-right"><a href="/home" class="btn btn-secondary">{{__('pagination.GoBack')}}</a></span></div>

                <div class="card-body">
                    {{ Form::open(array('action' => 'PaymentsController@store')) }}
                    {{--{{ method_field('HEAD') }}--}}
                    <div class="form-group">
                        {!! Form::label('name', __('pagination.Name')) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', __('pagination.Email')) !!}
                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('amount', __('pagination.Amount')) !!}
                        {!! Form::number('amount', null, ['class' => 'form-control','step' => 0.01]) !!}
                    </div>
                    <div class="form-group">
                        {{ Form::select('currency', $currencies, null, ['class'=>'form-control']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::select('banking_number', $bank, null, ['class'=>'form-control']) }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', __('pagination.Description')) !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                    </div>

                    <br>
                    {{Form::submit(__('pagination.CreatePayment'),['class' => 'btn-primary'])}}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection