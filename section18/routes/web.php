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


/*
|--------------------------------------------------------------------------
| Our CRUD Application
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\PostController;

Route::group(['middleware' => 'web'], function () {
    Route::resource('/post', PostController::class);
});

use Carbon\Carbon;

Route::get('/dates', function () {
    $date = new DateTime('+1 week');
    echo $date->format('m-d-y'); // 01-18-23
    echo "<br>";
    echo $date->format('m-d-y'); // 01-25-23
    echo "<br>";
    echo Carbon::now(); // 01-18-23 12:32:06
    echo "<br>";
    echo Carbon::now()->diffForHumans(); // 1 second ago
    echo "<br>";
    echo Carbon::now()->addDays(10)->diffForHumans(); // 1 week from now
    echo "<br>";
    echo Carbon::now()->subMonth(5)->diffForHumans(); // 5 months ago
    echo "<br>";
    echo Carbon::now()->yesterday()->diffForHumans(); // 1 day ago
});


Route::get('/getname', function () {
    $user = \App\Models\User::findOrFail(1);
    echo $user->name;
});

Route::get('/setname', function () {
    $user = \App\Models\User::findOrFail(1);
    $user->name = "arafat";
    $user->save();
});
