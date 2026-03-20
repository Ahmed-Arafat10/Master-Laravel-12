Create all resources except create & edit
````php
Route::resource('categories',CategoryController::class)
      ->except(['create', 'edit']);
````

<hr>

Create only index & show resources
````php
Route::resource('buyers', BuyerController::class)
      ->only(['index', 'show']);
````

<hr>

A new way to write it
````php
Route::resource('buyer',BuyerController::class,[
      'except' => ['create','update','destroy'],
      // Or    'only' => ['index'],
      'parameters' => ['buyer' => 'buyerID'],
      'middleware' => ['auth'],
      'prefix' => 'admin',
      ]);
````
> `'parameters' => ['buyer' => 'buyerID']` means when your run `php artisan route:list` then it will show query parameter to `buyerID` instead of `buyer`

<hr>

