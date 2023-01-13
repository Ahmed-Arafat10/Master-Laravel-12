<?php

# Laravel 8 Update



# On the lecture called "Routing Controllers" I show you how to route your requests using a controller.
# Laravel recently updated this feature and the code changed.

# You are going to see me, using a code similar to this below
Route::get('/', 'HomeController@index');

# Every time you see that code, you need to change it to something similar to the ones below

Route::get('/checking', '\App\Http\Controllers\HomeController@index');



# As you can probably tell, now we have to include the whole path of that controller in the method.
# OR
# You can also use the one below, which I like best.

use App\Http\Controllers\HomeController;

Route::get('/', [EdwinsController::class, 'index']);