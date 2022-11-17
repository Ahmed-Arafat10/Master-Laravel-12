<?php

# now we are going to learn Raw SQL Queries, we can make queries using a class called `model` & another thing called Eloquent

# in route file :
// insert a new row in a table
Route::get('/insert', function () {
    DB::insert('insert into posts (title, content) values (?,?)', ['DS', 'HELLO DS']);

});
