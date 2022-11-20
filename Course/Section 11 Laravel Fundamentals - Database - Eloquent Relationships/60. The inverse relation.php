<?php

# Get data of user from `User_ID` column in a post
# in `Post` Model class create following function

function GetUserDataFromPost()
{
    //return $this->belongsTo('App\Models\User', 'User_ID', 'id');
}

# then write a route

Route::get('/posts/{id}/user', function ($id) {
    // post1() is the function we wrote in User Model Class
    return Post::find($id)->GetUserDataFromPost;
    //return User::find($id)->post1->content;
});
