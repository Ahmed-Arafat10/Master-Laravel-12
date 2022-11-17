<?php
# ORM stands for Object Relational Mapper

// insert a record
Route::get('/elo_basicinsert', function () {
    // add a comparison in where statement + using FirstOrFail() to get just one record and if there is no records then throw an exception (404 not found)
    $post = new Post();
    $post->title = 'test ORM';
    $post->content = 'no wa home';
    $post->save();
});

// update a record
Route::get('/elo_basicupdate', function () {
    // add a comparison in where statement + using FirstOrFail() to get just one record and if there is no records then throw an exception (404 not found)
    $post = Post::find(2); // note it returns an object
    $post->title = 'test ORM 222';
    $post->content = 'no wa home 222';
    $post->save();
});


