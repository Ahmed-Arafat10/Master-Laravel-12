Here's how implicit model binding typically works in Laravel:

1. **Route Definition:**
   In your `routes/web.php` or `routes/api.php` file, you define a route that includes a route parameter to represent
   the model's primary key (e.g., `{user}`).

   ```php
   Route::get('/users/{user}', 'UserController@show');
   ```

2. **Controller Method:**
   In your controller, you define a method that accepts a parameter with the same name as the route parameter. Laravel
   will automatically resolve this parameter by fetching the corresponding model instance from the database based on the
   primary key.

   ```php
   public function show(User $user)
   {
       // $user is automatically resolved as an instance of the User model
       return view('users.show', compact('user'));
   }
   ```

   In this example, Laravel will retrieve a `User` model instance with the primary key specified in the URL and inject
   it into the `show` method.

3. **Route Model Binding Configuration (Optional):**
   You can further customize how the model binding works by defining a binding in the `RouteServiceProvider`. This is
   useful when you want to bind models by a different column or customize the resolution logic.

   ```php
   // In RouteServiceProvider.php
   public function boot()
   {
       parent::boot();

       Route::bind('user', function ($value) {
           return User::where('username', $value)->firstOrFail();
       });
   }
   ```

   This example binds the `user` route parameter to a `User` model based on the `username` column instead of the
   default `id`.

Please note that the specific implementation details may vary in Laravel 9 or any future versions released after my last
update. Always refer to the official Laravel documentation and release notes for the most up-to-date information on how
to use implicit model binding in your Laravel application.