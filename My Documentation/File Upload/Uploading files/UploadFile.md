- in `app` > `filesystem.php`

````php
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],
        'myImg' => [
            'driver' => 'local',
            'root' => public_path('uploads'),
            'visibility' => 'public',
        ],
````

> `myImg` is custom key created by me

- use it like this

````php
$img = $request->file('image');
$img->store('img', 'myImg');
````

- to delete from it

````php
        Storage::disk('myImg')->delete('img/' . $product->image);
````

> note that `img` path is relative to `uploads` path that is root path in key `MyImg

- update image in `update()` method

````php
if ($request->hasFile('image')) {
    if (Storage::disk('myImg')->exists('img/' . $product->image))
        Storage::disk('myImg')->delete('img/' . $product->image);
    $img = $request->file('image');
    $img->store('img', 'myImg');
    $product->image = $img->hashName();
 }
````