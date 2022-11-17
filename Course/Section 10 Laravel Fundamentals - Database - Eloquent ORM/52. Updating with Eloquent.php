<?php


Route::get('/elo_update', function () {
    Post::where('id', 4)->update(['title' => 'ORM updated DS']);
});
