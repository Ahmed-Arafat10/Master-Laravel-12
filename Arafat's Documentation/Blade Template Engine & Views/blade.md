- Second parameter can be sent to `@yield('title')`
````php
@section('title','K-Hub Home Page'),
````
> `'K-Hub Home Page'` is the parameter sent to `@yield('title')`



- Print generated CRSF value
````php
{{ csrf_token() }}
````

- Generate a hidden input with name _token with value = to csrf token generated
````php
{{ csrf_field() }}
````
