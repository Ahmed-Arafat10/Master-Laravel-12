@extends('layouts.app')

@section('content')
    <form method="POST" action="/post">
        {{ csrf_field() }}
        <label> Title:</label>
        <input type="text" name="title">
        <label> Content:</label>
        <input type="text" name="content">
        <input type="submit" name="submit">
    </form>
@endsection



@section('footer')
    <h2>Hello Create Page</h2>
@endsection
