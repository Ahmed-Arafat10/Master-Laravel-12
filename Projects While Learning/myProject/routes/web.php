<?php

use App\Http\Controllers\Controller;
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

Route::get('/ahmed',function()
{
    return "Hello Ahmed Arafat";
});

Route::get("/arafat/{id}/{name}",function($id,$name)
{
    return "your ID is ". $id. "Your name is ". $name;
});

Route::get("/ging/ahmed/arafat",array('as'=>"ging ahmed", function()
{
    $url = route('ging ahmed');
    return "this URL is ". $url;
}));

Route::get("/ging/ahmed/arafat",array('as'=>"ging ahmed", function()
{
    $url = route('ging ahmed');
    return "this URL is ". $url;
}));

//  \App\Http\Controllers\HomeController@index

// a route that calls a function index() in a controller named PostController
//Route::get('/Con','\App\Http\Controllers\PostController@index');

// pass a parameter to route & create function
//Route::get('/Con1/{id}','\App\Http\Controllers\PostController@create');

// to prevent typing whole path every time

use App\Http\Controllers\PostController;
use PhpParser\Node\Expr\PostInc;

//Route::get('/Con2/{id}',[PostController::class, 'create']);

Route::resource('/post','App\Http\Controllers\PostController');


Route::get('/Contact',[PostController::class,"ViewContact"]);

Route::get('/fun/{id}/{name}/{password}',[PostController::class,"Fun2"]);