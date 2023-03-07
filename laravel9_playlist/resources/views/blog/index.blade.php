{{--<h1>--}}
{{--    Hello From Index Page {{ var_dump($myposts) }}--}}
{{--</h1>--}}
@forelse($myposts as $singlepost)
    {{ $loop->count }}
@empty
    <p>no post has been set</p>
@endforelse
{{--<a href="{{ route('blog.index') }}">My Blog</a>--}}
{{--<a href="{{ route('blog.show',['id' => 1]) }}">Show Blog</a>--}}
