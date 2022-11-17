<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return "Hello Laravel";
});


Route::get('/admin/test', function () {
    return "Hello Admin";
});


Route::get('/human/{age}/{name}', function ($age, $name) {
    return "My name is " . $name . " My age is " . $age;
});

Route::get('/admin/fold/user', array('as' => 'admin.fold', function () {
    echo route('admin.fold');
    return view('welcome');
}));


Route::get('/testcont', '\App\Http\Controllers\PostController@index');

use \App\Http\Controllers\PostController;


Route::get('/testcont1/{id}', [PostController::class, 'index']);

Route::resource('posts', PostController::class);

Route::get('/contact', [PostController::class, 'ContactPage']);

Route::get('/helloarafat/{name}/{age}', [PostController::class, 'hello_page']);

Route::get('/contact33', [PostController::class, 'Contact33']);

/*
|--------------------------------------------------------------------------
| Raw SQL Queries
|--------------------------------------------------------------------------
*/

// insert a new row in a table
Route::get('/insert', function () {
    DB::insert('insert into posts (title, content) values (?,?)', ['DS', 'HELLO DS']);

});

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


// update statement
Route::get('/update', function () {
    $checkerror = DB::update('update posts set title = ? where id = ?', ['updated DS', 1]);
    return $checkerror;
});

// Delete Statement
Route::get('/delete', function () {
    return DB::delete('delete from posts where id = ? ', [5]);
});


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


Route::get('/elo_where', function () {
    // get() function return the data as an array
    // take() is like `limit` in SQL
    $res = Post::where('id', 3)->orderBy('id', 'desc')->take(1)->get();
    return $res;
});


Route::get('/elo_findmore', function () {
    // FindOrFail() is like find() but it throws an exception (404 not found) if record with a specific ID does not exists
    $res = Post::FindOrFail(5);
    return $res;
});


Route::get('/elo_where_fail', function () {
    // add a comparison in where statement + using FirstOrFail() to get just one record and if there is no records then throw an exception (404 not found)
    $res = Post::where('id', '>=', 4)->FirstOrFail();
    return $res;
});


Route::get('/elo_basicinsert', function () {
    // add a comparison in where statement + using FirstOrFail() to get just one record and if there is no records then throw an exception (404 not found)
    $post = new Post();
    $post->title = 'test ORM';
    $post->content = 'no wa home';
    $post->save();
});


Route::get('/elo_basicupdate', function () {
    // add a comparison in where statement + using FirstOrFail() to get just one record and if there is no records then throw an exception (404 not found)
    $post = Post::find(2);
    $post->title = 'test ORM 222';
    $post->content = 'no wa home 222';
    $post->save();
});


Route::get('/elo_insert', function () {
    // without adding fillable array in class `Post` it will give you an error (Add [title] to fillable property to allow mass assignment on [App\Models\Post].)
    Post::create(['title' => 'OOP', 'content' => 'hello OOP']);
});

Route::get('/elo_update', function () {
    Post::where('id', 4)->update(['title' => 'ORM updated DS']);
});
