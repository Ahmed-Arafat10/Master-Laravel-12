<?php

use App\Http\Controllers\FawryCardController;
use App\Http\Controllers\FawryController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('main-layout');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

//Route::get('/', function () {
//    return view('main-layout');
//});
//
Route::middleware('auth')->group(function () {
    Route::get('checkout', function () {
        return view('checkout');
    })->name('checkout');

    Route::get('transactions',[FawryController::class,'viewTransactions'])->name('transactions');

   Route::get('fawry-pay',[FawryController::class,'create'])->name('fawry.pay');
   Route::get('fawry-store-QR',[FawryController::class,'storeQR'])->name('fawry.store.QR');
   Route::post('fawry-store-R2f',[FawryController::class,'storeR2f'])->name('fawry.store.R2f');

   Route::get('fawry/card',[FawryController::class,'payWithCardView'])->name('fawry.card');
   Route::post('fawry/card',[FawryCardController::class,'issueToken'])->name('fawry.card.store');
   Route::get('fawry/card/callback',[FawryCardController::class,'callback']);
});

