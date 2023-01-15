@extends('layouts.app')

@section('content')
    <ul>
        @foreach($AllPosts as $post)
            <li> Title: {{$post->title}} & Content: {{$post->content}} </li>
        @endforeach
    </ul>
@endsection

@section('footer')
    <h2>Hello Index Page</h2>
@endsection
