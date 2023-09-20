- Insert a new row in Query Builder
````php
DB::table('xyz')->insert([
'key' => 12
]);
````

- Update a row in Query Builder
````php
DB::table('xyz')->where('id',12)->update([
        'key' => 12
]);
````

- Delete row in Query Builder
````php
DB::table('xyz')->where('id',12)->delete();
````