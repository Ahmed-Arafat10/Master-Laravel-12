
@isset($message)
    {{$message}}
@endisset
@if($errors->any())
    <ul>
        @foreach($errors->all() as $singleerror)
            <li> {{ $singleerror }}</li>
        @endforeach
    </ul>
@endif
<form method="POST" action="{{route('StoreNewUserData')}}">
    @csrf
    <label>name</label>
    <input type="text" name="name">
    <br>
    <label>email</label>
    <input type="email" name="email">
    <br>
    <label>password</label>
    <input type="password" name="password">
    <br>
    <label>confirm password</label>
    <input type="password" name="confpassword">
    <br>
    <button type="submit">Add</button>
</form>

