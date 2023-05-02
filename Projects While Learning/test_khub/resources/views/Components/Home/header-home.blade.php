<h1 {{ $attributes }}>
    {{ $slot }} </h1>
@isset($hi)
    @once
        {{$hi}}
    @endonce
@endisset
{{ $attributes->merge([
    'class'=> 'myclass2'
    ]) }}

class='{{$attributes->get('class')}}'
