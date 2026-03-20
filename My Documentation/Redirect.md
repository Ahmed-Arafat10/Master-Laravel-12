You can use a named route with the `redirect()->intended()` method by passing the named route as an argument to the method. Here's an example:

```php
use Illuminate\Http\Request;

Route::get('/dashboard', function (Request $request) {
    // This page requires authentication
    // If the user is not authenticated, Laravel will redirect them to the login page
    // After the user logs in, they will be redirected back to this page
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/login', function () {
    // This is the login page
    return view('login');
});

Route::post('/login', function (Request $request) {
    // Check if the user's credentials are valid
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // If the user's credentials are valid, redirect them back to the originally requested URL
        return redirect()->intended(route('dashboard'));
    } else {
        // If the user's credentials are invalid, redirect them back to the login page with an error message
        return redirect('/login')->with('error', 'Invalid credentials');
    }
});
```
> In the example above, the `/dashboard` route is named `dashboard` using the `name()` method. When the user is redirected back to the originally requested URL after logging in, we pass the named route `dashboard` as an argument to the `route()` function. The `route()` function generates the URL for the named route.
> Note that the named route must exist in your application's routes file, and you should make sure that the named route corresponds to the URL that the user originally requested.
