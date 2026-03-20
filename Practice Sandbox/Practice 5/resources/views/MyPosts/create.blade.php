@extends('layouts.app')

@section('content')
    {!! Form::open(['method'=>'POST','action'=>'App\Http\Controllers\PostController@store','files'=>true]) !!}
    <div class="form-group">
        {!! Form::label('title','Title:') !!}
        {!! Form::text('title',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('content','Content:') !!}
        {!! Form::text('content',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::file('myfile',['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Create A Post',['class'=>'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

    @if(count($errors) > 0)
        <ul class="alert alert-danger">
            @foreach($errors->all() as $SingleError)
                <li>{{$SingleError}}</li>
            @endforeach
        </ul>
    @endif

@endsection



@section('footer')
    <h2>Hello Create Page</h2>
@endsection
