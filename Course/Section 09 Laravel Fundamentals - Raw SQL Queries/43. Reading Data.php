<?php

// select statement (return more than one row)
Route::get('/select1', function () {
    $res = DB::select('SELECT * FROM posts where id >=3');
    echo '<pre>';
    print_r($res);
    foreach ($res as $single) {
        echo $single->title;
    }
});


// select statement (return one row)
Route::get('/select2', function () {
    $res = DB::select('SELECT * FROM posts where id = ?', [1]);
    var_dump($res);
    echo $res[0]->title;
});
