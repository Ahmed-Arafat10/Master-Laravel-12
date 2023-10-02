`Cross-Origin Resource Sharing (CORS)` is a security feature implemented by web browsers to prevent web pages from making requests to a different domain than the one that served the web page. Laravel 9, like its predecessors, allows you to configure CORS settings to control which domains are allowed to access your API.

- go to `config` > `cors.php`
````php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['*'],

    'allowed_methods' => ['*'],

    //'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')],
    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];

````
> Change it to be like `'allowed_origins' => ['*']` <br>
> Now any website can send an API Request to use & consume your APIs <br>
> Also you can specify specific domain(s) that can access your APIs, something like `'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')]`