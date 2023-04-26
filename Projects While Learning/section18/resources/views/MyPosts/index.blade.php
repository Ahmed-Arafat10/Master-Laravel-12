@extends('layouts.app')

@section('content')
    <ul>
        @foreach($AllPosts as $post)
            <div class="image-container">
                <img height="100" width="100" src="{{$post->path}}" alt="N/A">
            </div>
            <li>
                <a href="{{route('post.show',$post->id)}}"> Title: {{$post->title}} & Content: {{$post->content}} </a>
            </li>
        @endforeach
    </ul>
@endsection

@section('footer')
    <h2>Hello Index Page</h2>
@endsection
