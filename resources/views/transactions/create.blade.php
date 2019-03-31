@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('pagination.CreateBankAccount')}}<span class="float-right"><a href="/home" class="btn btn-secondary">{{__('pagination.GoBack')}}</a></span></div>

                <div class="card-body">
                    {{ Form::open(array('action' => 'TransactionsController@store')) }}
                    {{--{{ method_field('HEAD') }}--}}
                    <div class="form-group">
                        {{ Form::select('currency', $currencies, null, ['class'=>'form-control']) }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('iban', 'IBAN') !!}
                        {!! Form::text('iban', null, ['class' => 'form-control']) !!}
                    </div>
                    {{Form::submit(__('pagination.CreateBankAccount'),['class' => 'btn-primary'])}}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection