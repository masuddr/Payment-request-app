@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard<span class="float-right"><a href="/listings/create" class="btn btn-success btn-sm">Create</a></span></div>

                <div class="card-body">
                    <h3>Your listings</h3>
                    @if(count($banks))
                        <table class="table table-striped">
                            <tr>
                                <th>Company</th>
                                <th>Website</th>
                                <th>Email</th>

                            </tr>
                            @foreach($banks as $bank)
                                <tr>
                                    <th>{{$bank->name}}</th>
                                    <th>{{$bank->number}}</th>
                                                                      <th><a href="/listings/{{$bank->id}}/edit" class="btn btn-primary btn-sm">Edit</a>
                                    <th>   <form action="{{ action('ListingsController@destroy', $bank->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn-danger btn-sm float-right">Delete</button>
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
