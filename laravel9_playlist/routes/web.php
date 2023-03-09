<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PostController;
use \App\Http\Controllers\FallbackController;
use \App\Models\User;
use \App\Models\Post;

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

//Route::view('/', 'blog.index');
//
//Route::get('/blog', [PostController::class, 'index'])
//    ->name('blog.index');
//
//Route::get('/blog/{id}', [PostController::class, 'show'])
//    ->name('blog.show');
//
//Route::resource('/blog',PostController::class);


Route::fallback(FallbackController::class);


Route::prefix('/blog')->group(function () {
    Route::get('/create', [PostController::class, 'create'])
        ->name('AddAPost');
    Route::get('/', [PostController::class, 'index'])
        ->name('ViewAllPosts');
    Route::get('/{id}', [PostController::class, 'show'])
        ->name('ShowSinglePost');
    Route::post('/', [PostController::class, 'store'])
        ->name('StoreANewPost');;
    Route::get('/edit/{id}', [PostController::class, 'edit']);
    Route::patch('/{id}', [PostController::class, 'update']);
    Route::delete('/{id}', [PostController::class, 'destroy']);
});

//Route::get('/getmac', function () {
//    $macAddr = shell_exec('getmac');
//    dd($macAddr);
//});


# Used to create a new user
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
