- You can pass an array to `compact()` function like this
````php
Route::get('/new2/{id}', function ($id) {
    return view('test', compact([$id => 'id']));
});
````