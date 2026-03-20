The type of middleware you are referring to, where it modifies the headers of an incoming HTTP request, is often simply
referred to as "header modification middleware." This middleware type is used to intercept incoming requests and make
changes to the request headers before the request is processed further by the application.  
To create a custom middleware in Laravel that alters the headers of the incoming HTTP request, you can follow these
steps:

1. **Create the Middleware:**
   You can create a new middleware using Laravel's Artisan command-line tool. Open your terminal and run:

   ```bash
   php artisan make:middleware ModifyRequestHeaders
   ```

   This will generate a new middleware file named `ModifyRequestHeaders.php` in the `app/Http/Middleware` directory.

2. **Modify the Middleware:**
   Open the `ModifyRequestHeaders.php` file and add your logic to modify the request headers in the `handle` method. For
   example, you can add or modify headers as needed:

   ```php
   <?php

   namespace App\Http\Middleware;

   use Closure;

   class ModifyRequestHeaders
   {
       public function handle($request, Closure $next,$val)
       {
           // Modify headers here
           $response = $next($request);
           $response->headers->set('X-Application-Name', $val);
           return $response;
       }
   }
   ```

   In this example, we are adding a custom header named `X-Custom-Header` with the value `'Modified-Value'` to the
   incoming request.

3. **Register the Middleware:**
   To make the middleware active and apply it to specific routes or globally, you need to register it in
   the `app/Http/Kernel.php` file in `$middlewareAliases`.

 ```php
      protected $middlewareAliases = [
          // ...
          'modify.headers' => \App\Http\Middleware\ModifyRequestHeaders::class,
      ];
 ```
- To apply the middleware for `web`, you can add it to the `$middleware` property:

```php
        protected $middlewareGroups = [
        'web' => [
            'modify.headers:K-Hub',
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
```
> `'modify.headers:K-Hub'`, this is the parameter sent to `handle()` method with `$val` parameter as `K-Hub` <br>
> it is preferred to be the first middleware in the group
     
      