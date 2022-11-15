<?php

# if you want to make all function in a controller have a URL, you can type
Route::resource('posts',PostController::class);

/*
 the Output will be:
 GET|HEAD        posts ....................................................................................... posts.index › PostController@index
  POST            posts ....................................................................................... posts.store › PostController@store
  GET|HEAD        posts/create .............................................................................. posts.create › PostController@create
  GET|HEAD        posts/{post} .................................................................................. posts.show › PostController@show
  PUT|PATCH       posts/{post} .............................................................................. posts.update › PostController@update
  DELETE          posts/{post} ............................................................................ posts.destroy › PostController@destroy
  GET|HEAD        posts/{post}/edit ............................................................................. posts.edit › PostController@edit
 */

# this means that it creates route for each function + give a name for each on as [posts.store] for example