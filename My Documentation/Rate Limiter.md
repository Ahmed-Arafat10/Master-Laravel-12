- rate limiter in app > providers > `RouteServiceProvider.php`
````php
RateLimiter::for('api', function (Request $request) {
      return Limit::perMinute(40)->by($request->user()?->id ?: $request->ip());
});
````