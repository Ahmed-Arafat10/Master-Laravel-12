<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use \App\Http\Controllers\PostController;
use \App\Http\Controllers\UserController;
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
    Route::get('/edit/{id}', [PostController::class, 'edit'])
        ->name('GetPostToUpdate');
    Route::patch('/{id}', [PostController::class, 'update'])
        ->name('UpdateAPost');
    Route::delete('/{id}', [PostController::class, 'destroy'])
        ->name('DeleteAPost');
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

Route::get('/CreateUserPage', [UserController::class, 'create']);

Route::post('/store', [UserController::class, 'store'])
    ->name('StoreNewUserData');

Route::get('/showposts/{id}', [PostController::class, 'ShowAllPostsForAUser'])
    ->where([
        'id' => '[0-9]+'
    ])->name('ShowPostsForUser');





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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
