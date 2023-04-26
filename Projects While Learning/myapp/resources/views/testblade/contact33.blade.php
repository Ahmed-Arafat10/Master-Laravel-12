@extends('testblade.app')


@section('content')
    <h1>hello world</h1>

    @if(count($people))
        <ul>
            @foreach($people as $person)
                <li>Hello {{$person}}</li>
            @endforeach
        </ul>
    @endif
@endsection


@section('footer')
    {{--    <script>alert("hello my friend")</script>--}}
@endsection
