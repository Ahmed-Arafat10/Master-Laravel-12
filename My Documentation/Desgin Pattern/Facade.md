Create your class

````php
<?php

namespace App\Http\Services;

class MyService
{
    public function goodMorning($name)
    {
        echo "Good Morning {$name}";
    }
}
````

Create a facade class that extends `Facade`

````php
<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;

class MyServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MyService';
    }
}
````

Register the `MyService` in `AppServiceProvider`

````php
<?php

namespace App\Providers;

use App\Http\Services\MyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('MyService', function () {
            return new MyService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
````

Now you can use it in any route or controller
````php
use App\Http\Facades\MyServiceFacade as MyService;
Route::get('/facade', function () {
    return MyService::goodMorning('Ahmed');
});
````