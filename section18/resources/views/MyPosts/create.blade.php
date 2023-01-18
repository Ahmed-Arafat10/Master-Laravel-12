@extends('layouts.app')

@section('content')
    {!! Form::open(['method'=>'POST','action'=>'App\Http\Controllers\PostController@store']) !!}
    <div class="form-group">
        {!! Form::label('title','Title:') !!}
        {!! Form::text('title',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('content','Content:') !!}
        {!! Form::text('content',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Create A Post',['class'=>'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@endsection



@section('footer')
    <h2>Hello Create Page</h2>
@endsection
