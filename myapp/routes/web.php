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
use App\Models\User;


Route::get('/elo_read', function () {

    $posts = Post::all(); // fetch all record in table `posts`
    echo '<pre>';
    print_r($posts[0]->title);// print title of first row

    // print all data
    foreach ($posts as $single) {
        //echo $single->title . "<br/>";
        echo '<pre>';
        print_r($single->id);
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


Route::get('/elo_insert/{title}/{content}', function ($title, $content) {
    // without adding fillable array in class `Post` it will give you an error (Add [title] to fillable property to allow mass assignment on [App\Models\Post].)
    Post::create(['title' => $title, 'content' => $content]);
});

Route::get('/elo_update', function () {
    Post::where('id', 4)->update(['title' => 'ORM updated DS']);
});


// Method #1 to delete
Route::get('/elo_delete1', function () {
    $res = Post::find(1);
    //$res->delete(); // note if the ID does not exist it will show an errors as $res is NULL
    // to solve this
    if ($res) $res->delete();
    else echo "ID not found";
});


// Method #2 to delete
Route::get('/elo_delete2', function () {
    return Post::destroy(1); // will return 0 as ID 1 does not exist
    // or delete multiple records
    Post::destroy([3, 4]);
});


// Method #3 to delete
Route::get('/elo_delete3', function () {
    return Post::where('id', 2)->delete();
});


// soft delete of a row (as we know it will not actually delete it will just add delete time in `deleted_at` column)
Route::get('/elo_softdelete', function () {
    return Post::find(10)->delete();
});


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


Route::get('/elo_restoresoftdelete', function () {
    // function restore() will convert soft deleted records shown in the following select query into normal records
    // you can also use withTrashed() function, depends on the case
    $res = Post::onlyTrashed()->where('is_admin', 0)->restore();
    return $res;
});


Route::get('/elo_getonlysoftdelete', function () {
    // function restore() will convert soft deleted records shown in the following select query into normal records
    // you can also use withTrashed() function, depends on the case
    $res = Post::onlyTrashed()->get();
    return $res;
});

Route::get('/elo_force_delete_soft_delete', function () {
    // forceDelete() will directly delete the row(s), not just change the date in `deleted_at` column as in soft delete
    $res = Post::onlyTrashed()->where('id', 10)->forceDelete();
    return $res;
});


/*
|--------------------------------------------------------------------------
| ELOQUENT Relationships
 |--------------------------------------------------------------------------
*/

// One-to-One relationship
Route::get('/user/{id}/posts', function ($id) {
    // post1() is the function we wrote in User Model Class
    return User::find($id)->post1;
    //return User::find($id)->post1->content;
});


// get data of user from `User_ID` column in a post
Route::get('/posts/{id}/user', function ($id) {
    // post1() is the function we wrote in User Model Class
    return Post::find($id)->GetUserDataFromPost;
    //return User::find($id)->post1->content;
});


// one-to-many relationship
Route::get('/all_posts_for_user/{id}', function ($id) {
    $user = User::find($id);
    foreach ($user->allposts as $single) {
        echo $single->title . "<br>";
    }
});
