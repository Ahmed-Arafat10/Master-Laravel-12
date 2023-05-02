<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
{{--    {{ json_encode(Route::getRoutes()->nameList) }}--}}
    <script>
        let routeList = {!! json_encode(Route::getRoutes()->getRoutesByName()) !!};
        console.log(routeList);
    </script>
    <script src="{{ asset('js/test.js') }}"></script>

    @php
    $res = \Illuminate\Support\Facades\Route::getRoutes()->getRoutesByName();
    dd($res['HOME']);
    @endphp
{{--    {{ json_encode(Route::getRoutes()->getByName('HOME'))}}--}}
    <style>
        .myclass{
            background-color: #1a202c;
            color: #9ca3af;
        }
        .myclass2{
           text-align: right;
        }
    </style>
</head>
<body>
{{--    <x-Home.header-home style="text-align: center" class="myclass"> Arafat </x-Home.header-home>--}}
{{--    <x-Home.header-home> Arafat </x-Home.header-home>--}}
{{--Dont use capital characters in variables name in html --}}
    <x-Home.test-home :txt="'ahmed'"> dfs </x-Home.test-home>


{{ route('HOME') }}
</body>
</html>
