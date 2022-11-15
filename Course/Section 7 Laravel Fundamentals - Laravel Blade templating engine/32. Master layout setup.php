<?php

# as we said before blade is a template engine that help us to write shorter php statements
# lets create a file in a folder called `testblade/app.blade.php`

/*
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container">
    @yield('content')
</div>
@yield('footer')
</body>
</html>
*/

# @yield('content')/@yield('footer')    ---> create a section called content & footer

# in contact page type:
/*
@extends('testblade.app')


@section('content')
<h1>hello world</h1>
@endsection


@section('footer')
<script>alert("hello my friend")</script>
@endsection

*/

# as you can see @extends('testblade.app') is like include(), import all code in that file

# while @section('content') means it search for @yield('content') and insert the code in section body
# @endsection is the end of that section like } in programming

