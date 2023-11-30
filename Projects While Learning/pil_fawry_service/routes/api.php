<?php

use App\Http\Controllers\FawryCardController;
use App\Http\Controllers\FawryEwalletController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(FawryCardController::class)
        ->prefix('fawry/card')
        ->name('fawry.card.')
        ->group(function () {
            Route::post('issue-token', 'issueToken');
            Route::post('pay-with-card', 'payWithCardToken');
            Route::get('callback', 'callback');
            Route::get('get-customer-tokens', 'getCard');

        });

    Route::controller(FawryEwalletController::class)
        ->prefix('fawry/ewallet')
        ->name('fawry.ewallet.')
        ->group(function () {
            Route::get('transactions', 'viewTransactions');
            Route::get('pay-r2f', 'storeR2f');
            Route::get('pay-qr', 'storeQR');
        });
});

Route::controller(UserController::class)
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::post('signup', 'signup');
        Route::post('signin', 'signin');
        Route::get('403', 'auth')->name('403');
    });

