<?php

# To pass a variable from URL to a function in a controller
# add for that function a parameter(s)
function index($id)
{
    return "It's Working Guys" . " ID is: ". $id;
}

# Then in route file just add variable in the URL

Route::get('/testcont1/{id}',[PostController::class,'index']);
