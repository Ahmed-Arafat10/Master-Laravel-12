@extends('layouts.app')

@section('content')
    <h4>Edit Post Page</h4>

    {{--    {!! Form::open(['method'=>'PATCH','action'=> ['App\Http\Controllers\PostController@update',$PostToEdit->id]]) !!}--}}
    {!! Form::model($PostToEdit,['method'=>'PATCH','action'=> ['App\Http\Controllers\PostController@update',$PostToEdit->id]]) !!}
    <div class="form-group">
        {!! Form::label('title',"Title:") !!}
        {!! Form::text('title',$PostToEdit->title,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('content',"Content:") !!}
        {!! Form::text('content',$PostToEdit->content,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Update Post',['class'=>'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}


    {!! Form::open(['method'=>'DELETE','action'=> ['App\Http\Controllers\PostController@destroy',$PostToEdit->id]]) !!}
    <div class="form-group">
        {!! Form::submit('Delete Post',['class'=>'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

@endsection


@section('footer')
    <h2>Hello Edit Page</h2>
@endsection
