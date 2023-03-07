<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


use \App\Http\Controllers\PostController;

//Route::view('/', 'blog.index');
//
//Route::get('/blog', [PostController::class, 'index'])
//    ->name('blog.index');
//
//Route::get('/blog/{id}', [PostController::class, 'show'])
//    ->name('blog.show');
//
//Route::resource('/blog',PostController::class);

Route::prefix('/blog')->group(function () {
    Route::get('/blog', [PostController::class, 'index']);
    Route::get('/blog/{id}', [PostController::class, 'show']);
    Route::get('/blog/create', [PostController::class, 'create']);
    Route::post('/blog', [PostController::class, 'store']);
    Route::get('/blog/edit/{id}', [PostController::class, 'edit']);
    Route::patch('/blog/{id}', [PostController::class, 'update']);
    Route::delete('/blog/{id}', [PostController::class, 'destroy']);
});

use \App\Http\Controllers\FallbackController;

Route::fallback(FallbackController::class);


Route::get('/getmac', function () {
    $macAddr = shell_exec('getmac');
    dd($macAddr);
});


# Used to create a new user
use \App\Models\User;

Route::get('/createuser/{name}/{email}/{pass}', function ($name, $email, $pass) {
    User::create([
        'name' => $name,
        'email' => $email,
        'password' => $pass
    ]);
})->where([
    'name' => '[A-Za-z]+',
    'email' => '[A-Za-z]+',
    'pass' => '[A-Za-z0-9]+'
]);

Route::get('/show/{id}', [PostController::class, 'show'])
    ->whereNumber('id')
    ->name('MyShowRoute');
