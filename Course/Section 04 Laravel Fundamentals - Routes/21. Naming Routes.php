<?php

# you can give a shortcut name to your view if path is long
# add an array in the second parameter then first index add `as` key and make it refers to new name
# then in the next index add your closure function, note that it is inside the array
# then you can access whole URL by printing calling route() function and passing shortcut name of the route

Route::get('/admin/fold/user',array('as'=>'admin.fold',function(){
    echo route('admin.fold');
    return view('welcome');
}));

# in terminal type following command to print all your routes
# $ php artisan route:list
