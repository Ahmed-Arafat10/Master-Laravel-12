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

Route::view('/', 'blog.index');

Route::get('/blog', [PostController::class, 'index'])
    ->name('blog.index');

Route::get('/blog/{id}', [PostController::class, 'show'])
    ->name('blog.show');

Route::resource('/blog',PostController::class);
