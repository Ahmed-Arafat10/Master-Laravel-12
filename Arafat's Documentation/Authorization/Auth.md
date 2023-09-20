## ChatGPT : How to make Two Guards for admin & user
To create separate authentication guards for admin and user in Laravel 9, you can follow these steps:

1. Define two different authentication guards in the `config/auth.php` file. You can define multiple authentication guards in Laravel, each with its own driver and user provider.

Here's an example of how to define two guards named `admin` and `user`:

```php
'guards' => [
    'admin' => [
        'driver' => 'session',
        'provider' => 'admin_users',
    ],

    'user' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
],
```

In the example above, we define two guards, one for `admin` and another for `user`. Each guard has its own driver and user provider.

2. Define two different authentication providers for `admin` and `user` in the `config/auth.php` file. You can define multiple authentication providers in Laravel, each with its own driver and model.

Here's an example of how to define two providers named `admin_users` and `users`:

```php
'providers' => [
    'admin_users' => [
        'driver' => 'eloquent',
        'model' => App\Models\AdminUser::class,
    ],

    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
],
```

In the example above, we define two providers, one for `admin_users` and another for `users`. Each provider has its own driver and model.

3. Use the `auth` middleware to protect routes based on the specific guard that you want to use. You can use the `auth:guard` middleware to specify which guard should be used to authenticate the user.

Here's an example of how to use the `auth` middleware for protecting routes based on the specific guard:

```php
Route::group(['middleware' => ['auth:admin']], function () {
    // routes for admin users
});

Route::group(['middleware' => ['auth:user']], function () {
    // routes for regular users
});
```

In the example above, we use the `auth:admin` middleware to protect routes for admin users, and `auth:user` middleware to protect routes for regular users.

4. Use the `Auth::guard()` method to switch between the two guards. You can use the `Auth::guard()` method to switch between guards when you need to authenticate a user.

Here's an example of how to use the `Auth::guard()` method to switch between guards:

```php
// Authenticate admin user
Auth::guard('admin')->attempt($credentials);

// Authenticate regular user
Auth::guard('user')->attempt($credentials);
```
In the example above, we use the `Auth::guard()` method to switch between guards to authenticate a user based on the specific guard.
<hr>
