````php
composer require laravel/socialite
````

- in config > services.php
````php
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => 'http://127.0.0.1:8000/google/callback',
    ],
````

- in `.env`
````php
GOOGLE_CLIENT_ID="70944905132-b173b5mupsvb3brq41n931jv12aa.apps.googleusercontent.com"
GOOGLE_CLIENT_SECRET="GOCSPX-hMG6HwXwoBXdHY458pVXlC2BG4"
````


- in web.php
````php
Route::controller(GoogleController::class)
    ->prefix('google')
    ->name('google.')
    ->group(function () {
        Route::get('redirect', 'redirectToGoogle');
        Route::get('callback', 'handleGoogleCallback');
    });
````


- in `GoogleController.php`:
````php
<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            //create a user using socialite driver google
            $user = Socialite::driver('google')->user();
            dd($user);
            //catch exceptions
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
````

> Doc : https://laravel.com/docs/10.x/socialite <br>
> Article : https://codyrigg.medium.com/how-to-add-a-google-login-using-socialite-on-laravel-8-with-jetstream-6153581e7dc9