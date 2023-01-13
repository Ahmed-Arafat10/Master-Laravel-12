<?php

# inside `routes` > `web.php` you can add your route
# Route is class & get() is a static function
# it means that when you type following get request in the  url this function will be executed
# function inside the parameter is called `closure function`
# each route returns a view
# a view is html representation of your page

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello',function (){
    return "Hello Laravel";
});


Route::get('/admin/test',function (){
    return "Hello Admin";
});
