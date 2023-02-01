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

use \App\Models\User;

Route::get('/createuser', function () {
    User::create([
        'name' => 'Ahmed',
        'email' => 'ahmed@gmail.com',
        'password' => bcrypt('123')
    ]);
});

Route::get('/onetoone/{userid}', function ($userid) {
    $user = User::findOrFail($userid);
    //dd($user);
    var_dump($user->phonehhh);
});
Route::get('/onetoone_phone/{phoneid}', function ($phoneid) {
    $phone = \App\Models\Phone::findOrFail($phoneid);
    //dd($phone);
    var_dump($phone->ufser);
});


Route::resource('cars', \App\Http\Controllers\CarController::class);


Route::get('/getcarfrommodel/{id}', [\App\Http\Controllers\CarController::class, 'show_carmodel']);
