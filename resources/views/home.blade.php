@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard darjush
                    <span class="float-right">
                        <a href="/payments/create" class="btn btn-success btn-sm">{{__('pagination.CreatePayment')}}</a>
                    </span>
                </div>
                <table border="1" cellpadding="3">
                    <tr><td colspan="2" align="center">{{__('pagination.YourInfo')}}</td></tr>
                    <tr>
                        <td>{{__('pagination.Name')}}: {{$user->name}}</td>
                    </tr>

                    <tr>
                        <td>{{__('pagination.Email')}}: {{$user->email}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
