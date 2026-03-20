<?php

# now we will create a new page that take an array and then print its values

# first we create the route
Route::get('/contact33', [PostController::class, 'Contact33']);

# then in controller file we create following function
function Contact33()
{
    $people = ["ahmed", 'mohamed', 'yousry', 'arafat'];
    return view('testblade.contact33', compact('people'));
}

# as we can see we can pass an array to compact()

# then in contact33.blade.php

/*
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

 */
