<?php

# After creating a controller, you can access it & call its functions from route
# just make second parameter the FULL path to controller file
# then type `@` then name f the function

Route::get('/testcont','\App\Http\Controllers\PostController@index');


# to make typing the controller much more easy task, you can define the whole path
use \App\Http\Controllers\PostController;

Route::get('/testcont1',[PostController::class,'index']);
