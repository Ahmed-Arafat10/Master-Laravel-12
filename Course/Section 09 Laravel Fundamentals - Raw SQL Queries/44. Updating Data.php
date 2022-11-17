<?php
    
// update statement
Route::get('/update', function () {
    $checkerror = DB::update('update posts set title = ? where id = ?', ['updated DS', 1]);
    return $checkerror;
});
