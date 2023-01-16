@extends('layouts.app')

@section('content')
    <h4>Edit Post Page</h4>

    <form method="POST" action="/post/{{$PostToEdit->id}}">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <label> Title:</label>
        <input type="text" name="title" value="{{$PostToEdit->title}}">
        <label> Content:</label>
        <input type="text" name="content" value="{{$PostToEdit->content}}">
        <input type="submit" name="submit" value="UPDATE">
    </form>

    <form method="post" action="/post/{{$PostToEdit->id}}">
        {{csrf_field()}}
        <input hidden name="_method" value="DELETE">
        <input type="submit" name="submit" value="DELETE">
    </form>
@endsection


@section('footer')
    <h2>Hello Edit Page</h2>
@endsection
