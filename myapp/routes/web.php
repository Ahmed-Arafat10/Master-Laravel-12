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
