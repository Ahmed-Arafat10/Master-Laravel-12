@extends('layouts.app')

@section('content')
    <h2>{{$MyPost->title}} & {{$MyPost->content}}</h2>
    <a href="{{route('post.edit',$MyPost->id)}}">update it</a>
@endsection


@section('footer')
    <h1>My Show Page</h1>
@endsection
