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

// many-to-many relationship
Route::get('/get_user_roles/{id}', function ($id) {
    $user = User::find($id)->GetUserRoles;
    // note: you can chain function like following example, but in this case you must add () of function GetUserRoles
    //$user = User::find($id)->GetUserRoles()->orderBy('id', 'asc')->get();
    return $user;
});

// many-to-many relationship
Route::get('/get_role_user/{id}', function ($id) {
    $role = \App\Models\Role::find($id)->GetUserData;
    // note: you can chain function like following example, but in this case you must add () of function GetUserRoles
    //$user = User::find($id)->GetUserRoles()->orderBy('id', 'asc')->get();
    return $role;
});


Route::get('user/pivot/{id}', function ($id) {
    $user = User::find($id)->GetUserRoles2;
    foreach ($user as $item) {
        // pivot will return -> {"user_id":2,"role_id":2}
        echo $item . "<br>";
        //echo $item->pivot->created_at . "<br>";
    }
});

use \App\Models\Country;

Route::get('user/country/{id}', function ($id) {
    $country = Country::find($id);
    foreach ($country->posts as $item) {
        echo "<pre>";
        echo $item;
    }
});


Route::get('/user/photo/{id}', function ($id) {
    $user = User::find($id);
    echo $user;// {"id":1,"name":"arafat","email":"ahmed@gmail.com","email_verified_at":null,"created_at":null,"updated_at":null,"country_id":1}
    foreach ($user->photos as $photo) {
        echo $photo;// {"id":1,"path":"ahmed.png","imageable_id":1,"imageable_type":"App\\Models\\User","created_at":null,"updated_at":null}
    }
});

Route::get('/post/photo/{id}', function ($id) {
    $post = Post::find($id);
    echo $post;// {"id":7,"title":"OOP","content":"hello OOP","created_at":"2022-11-17T02:07:04.000000Z","updated_at":"2022-11-17T02:07:04.000000Z","is_admin":0,"deleted_at":null,"User_ID":1}
    foreach ($post->photos as $photo) {
        echo $photo; // {"id":13,"path":"test.png","imageable_id":7,"imageable_type":"App\\Models\\Post","created_at":null,"updated_at":null}{"id":13,"path":"test.png","imageable_id":7,"imageable_type":"App\\Models\\Post","created_at":null,"updated_at":null}
    }
});

use \App\Models\Photo;

// `{id}` is PK column of table `photo`
Route::get('photo/{id}/corresponding_data', function ($id) {
    $photo = Photo::findOrFail($id);
    return $photo->imageable;
});

use App\Models\Video;

Route::get('tags/{type}/{id}/corresponding_data', function ($type, $id) {
    if ($type == "post") {
        $Posts = Post::findOrFail($id);
        echo $Posts;
        foreach ($Posts->tags as $p) {
            echo $p;
        }
    } else {
        $videos = Video::findOrFail($id);
        echo $videos;
        foreach ($videos->tags as $video) {
            echo $video;
        }
    }
});

use App\Models\Tag;

Route::get('searchbytag/{type}/{tag_id}', function ($type, $tag_id) {
    $tag = Tag::Find($tag_id);
    if ($type == "post") {
        // now I'm printing the posts that have a polymorphic relationship with a specific tag {tag_id}
        // all in `taggables` table
        foreach ($tag->posts as $p) {
            echo $p;
        }
    } else {
        // same as above but this time with video not post
        foreach ($tag->videos as $v) {
            echo $v;
        }
    }
});


use App\Models\ztmp_address;

Route::get('/insert_user_address', function () {
    $user = User::findOrFail(1);

    $address = new ztmp_address(['name' => 'El-Haram']);
    $user->address()->save($address);
});


Route::get('/update_user_address', function () {
    //$address = ztmp_address::where('user_id',1);
    //$address = ztmp_address::where('user_id',">=",1);
    $address = ztmp_address::whereUserId(1)->first();
    $address->name = "updated row1";
    $address->save();
});


Route::get('/read_user_address', function () {
    $user = User::findOrFail(1);
    echo $user->address->name;
});

Route::get('/delete_user_address', function () {
    $user = User::findOrFail(1);
    $user->address->delete();
});

use App\Models\ztmp_post;
use App\Models\ztmp_user;

Route::get('/insert_user_ztmp_post', function () {
    $user = ztmp_user::findOrFail(1);
    //$ztemp_post = new ztmp_post(['title' => 'hello world', 'body' => 'testing the body']);
    //$user->ztemp_post()->save($ztemp_post);
    // Just in one line
    $user->ztemp_post()->save(new ztmp_post(['title' => 'hello world lts', 'body' => 'testing the body lts']));
});


Route::get("/view_user_ztmp_post", function () {
    $user = ztmp_user::findOrFail(1);
    //dd($user->ztemp_post);
    foreach ($user->ztemp_post as $SinglePost) {
        echo $SinglePost->body . "<br>";
    }
});


Route::get("/update_user_ztmp_post", function () {
    $user = ztmp_user::findOrFail(1);
    $post = $user->ztemp_post()->whereId(2)->update(['title' => "updated hello world"]);
    //$post = $user->ztemp_post()->where('id',2)->update(['title' => "updated hello world"]);
});


Route::get("/delete_user_ztmp_post", function () {
    $user = ztmp_user::findOrFail(1);
    $post = $user->ztemp_post()->whereId(5)->delete();
});

use \App\Models\mtm_Role;
use \App\Models\mtm_user;

Route::get('/mtm_insert_role', function () {
    $user = mtm_user::find(1);
    $user->mtm_role()->save(new mtm_Role(['name' => "Back-End Developer"]));
});

Route::get('/mtm_select_user_role', function () {
    $user = mtm_user::findOrFail(1);

    foreach ($user->mtm_role as $single_row) {
        dd($single_row);
        //echo $single_row;
    }
});

Route::get('/mtm_update_user_role', function () {
    $user = mtm_user::findOrFail(1);
    if ($user->has('mtm_Role')) {
        foreach ($user->mtm_role as $single) {
            if ($single->name == "Front-End Developer") {
                $single->name = "Updated Front-End Developer";
                $single->save();
            }
        }
    }
});

Route::get('/mtm_delete_user_role', function () {
    $user = mtm_user::findOrFail(1);
    //$user->mtm_role()->delete();
    foreach ($user->mtm_role as $single) {
        $single->whereId('16')->delete();
        //dd($single);
    }
});


# 101 start------------------------------------------------------

// this route will create a new record in `mtm_role_user` between user with ID 1 & roles with ID 16
Route::get('/attach', function () {
    $user = mtm_user::findOrFail(1);
    $user->mtm_role()->attach(16);
});


// this route will create delete ALL record(s) in `mtm_role_user` between user with ID 1 & roles with ID 16
Route::get('/detach', function () {
    $user = mtm_user::findOrFail(1);
    $user->mtm_role()->detach(16);
});


Route::get('/sync', function () {
    $user = mtm_user::findOrFail(1);
    $user->mtm_role()->sync([17]);// must pass an array
});


# 101 end------------------------------------------------------


###############################################################
# Section 16 Database - Eloquent Polymorphic Relationship CRUD
###############################################################


# 104. start----------------------------------------------------
use \App\Models\poly_staff;
use \App\Models\poly_product;

Route::get('poly_create', function () {
    $staff = poly_staff::findOrFail(1);
    $staff->image()->create(['path' => 'Ging.png']);
});
# 104. end----------------------------------------------------


# 105. end----------------------------------------------------
Route::get('poly_read', function () {
    $staff = poly_staff::findOrFail(1);
    foreach ($staff->image as $i) {
        echo $i;
        //echo $i->path;
    }
});
# 105. end----------------------------------------------------


# 106. start----------------------------------------------------
Route::get('poly_update', function () {
    $staff = poly_staff::findOrFail(1);
    $p = $staff->image()->first();
    $p->path = "Updated " . $p->path;
    $p->save();
});
# 106. end----------------------------------------------------

# 107. start----------------------------------------------------
Route::get('poly_update', function () {
    $staff = poly_staff::findOrFail(1);
    $p = $staff->image()->delete();
});
# 107. end----------------------------------------------------


# 108. start----------------------------------------------------
Route::get('/assign', function () {
    $staff = poly_staff::findOrFail(1);
    $image = \App\Models\poly_photo::findOrFail(3);// ID of that record
    $staff->image()->save($image);
});

Route::get('/reassign', function () {
    $staff = poly_staff::findOrFail(1);
    $staff->image()->whereId(3)->update(['imageable_id' => NULL, 'imageable_type' => NULL]);

    //Or
    //$image = \App\Models\poly_photo::findOrFail(3);// ID of that record
    //$staff->image()->update(['imageable_id' => NULL, 'imageable_type' => NULL]);
});


# 108. end----------------------------------------------------


############################################################################
# Section 17: Database - Eloquent Polymorphic Many to Many Relationship CRUD
############################################################################


# 111. start---------------------------------------------------
use App\Models\poly_mtm_tag;
use App\Models\poly_mtm_post;
use App\Models\poly_mtm_video;
use App\Models\poly_mtm_taggable;

Route::get('/poly_mtm_insert', function () {
    $post = poly_mtm_post::create(['name' => 'My Post Ahmed']);
    $tag1 = poly_mtm_tag::findOrFail(1);
    $post->tags()->save($tag1);

    $video = poly_mtm_video::create(['name' => 'My Video Ahmed']);
    $tag2 = poly_mtm_tag::findOrFail(2);
    $video->tags()->save($tag2);

});
# 111. end-----------------------------------------------------

