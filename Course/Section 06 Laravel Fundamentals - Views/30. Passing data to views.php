<?php

# to pass a parameter to a view


# then in `web.app` file write following route to call ContactPage() function from `PostController` file
Route::get('/helloarafat/{name}/{age}',[PostController::class,'hello_page']);

# don't forget to add parameter in the hello_page() function in controller
function hello_page($name,$age)
{
    # with() works only with one parameter
    // return view('hello')->with('name',$name); -> cannot add $age
   # instead we can use compact() with parameters having he same name as hello_page($name,$age) but AS STRING
    return view('hello',compact('name','age'));
}

# on `hello.blade.php` file,  you can write your HTML code
# <h1> Hello {{$name}}, your age is : {{$age}}</h1>

# as you can see {{$name}} -> is evaluated by <?php echo $name ?>