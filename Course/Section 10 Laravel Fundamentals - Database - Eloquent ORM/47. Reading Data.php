<?php

# model class allow us dealing with database using eloquent feature in Laravel
# to create a model type following command
# $ php artisan make:model ModelName

# if you want to create a migration also add [-m] flag
# $ php artisan make:model -m

# models files are stored in same level as `App` > `Models` folder (Laravel 9)

# if you pressed ctrl then referred the mouse on any class (for example class model) & then clicked on the class you will then see the definition of that class

# inside file `App\Models\Post.php`

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAdmin extends Model
{
    // use HasFactory;

    // to change default table name
    protected $table = 'posts'; // by default is name of class in lowercase + `s` at end
    // then PostAdmin class will have a table by default called --> postadmins
    //protected $table = '__Post';

    // protected $primaryKey = 'post_id';// by default is `id`
}


/*
|--------------------------------------------------------------------------
| ELOQUENT
|--------------------------------------------------------------------------
*/

// to import class Post
use App\Models\Post;

Route::get('/elo_read', function () {

    $posts = Post::all(); // fetch all record in table `posts`
    echo '<pre>';
    print_r($posts[0]->title);// print title of first row

    // print all data
    foreach ($posts as $single) {
        //echo $single->title . "<br/>";
        echo '<pre>';
        print_r($single);
    }
});

Route::get('/elo_find', function () {
    // don't forget to check if find() really returned a values or the record ID does not exists
    $onepost = Post::find(1); // fetch all record in table `posts`
    echo '<pre>';
    print_r($onepost->attributesToArray());// print all attributes of the record
});

Rout::get('/elo_where', function () {
    $res = Post::where('id', 1)->orderBy('id', 'desc');
    return $res;
});