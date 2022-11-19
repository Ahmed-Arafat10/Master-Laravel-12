<?php

# as we said before
# note: if you read records of posts table using [select *] then all soft deleted records will not be shown in the
# query result BY DEFAULT

Route::get('/elo_readsoftdelete1', function () {
    // withTrashed() function will show both soft deleted & normal records
    $res = Post::withTrashed()->where('is_admin', 0)->get();
    return $res;
});


Route::get('/elo_readsoftdelete2', function () {
    // onlyTrashed() function will show ONLY soft deleted records
    $res = Post::onlyTrashed()->where('is_admin', 0)->get();
    return $res;
});