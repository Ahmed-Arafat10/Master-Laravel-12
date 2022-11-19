<?php
Route::get('/elo_force_delete_soft_delete', function () {
    // forceDelete() will directly delete the row(s), not just change the date in `deleted_at` column as in soft delete
    // delete record with id 10 (alreafy soft deleted)
    $res = Post::onlyTrashed()->where('id', 10)->forceDelete();
    // delete all soft deleted records
    $res = Post::onlyTrashed()->forceDelete();
    return $res;
});
