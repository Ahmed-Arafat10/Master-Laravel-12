@extends('layouts.app')

@section('content')
    <ul>
        @foreach($AllPosts as $post)
            <li><a href="{{route('post.show',$post->id)}}"> Title: {{$post->title}} & Content: {{$post->content}} </a>
            </li>
        @endforeach
    </ul>
@endsection

@section('footer')
    <h2>Hello Index Page</h2>
@endsection
