<?php

# same idea as previous files
# just use hasMany()

function allposts()
{
    // return $this->hasMany('App\Models\Post', 'User_ID', 'id');
}


// one-to-many relationship
Route::get('/all_posts_for_user/{id}', function ($id) {
    $user = User::find($id);
    foreach ($user->allposts as $single) {
        echo $single->title . "<br>";
    }
});
