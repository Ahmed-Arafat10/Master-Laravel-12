- first Download MongoDB Compass

- Add in `php.init`
````php
extension=mongodb
````

- Now you have to download MongoDB extension for PHP, For PHP 8.2 download zip folder with name
````php
php_mongodb-1.16.2-8.2-ts-x64
````
> get `.dll` file then move it to `xampp/php/ext`, then restart the apache server

- In your `composer.json` add for `require` 
````php
"mongodb/laravel-mongodb": "dev-master"
````
> then hit `composer update`


- In `config/database.php`
````php
'mongodb' => [
            'driver' => 'mongodb',
            'dsn' => env('MONGO_DB_DSN'),
            'database' => env('DB_DATABASE', 'N/A'),
        ],
````

- in `.env`
````php
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test_laravel
DB_USERNAME=root
DB_PASSWORD=

MONGO_DB_DSN=mongodb+srv://arafat:Ahmed123@cluster0.it4s83q.mongodb.net/?retryWrites=true&w=majority
````
> get `MONGO_DB_DSN=` from `MongoDB Atlas`, just add your password to the URL <br>
> `DB_DATABASE` will be name of DB in Compass, in this case it is `test_laravel`


- Set the default database connection name in `config\database.php`:

````php
   /*
    |--------------------------------------------------------------------------
| Default Database Connection Name
    |--------------------------------------------------------------------------
|
| Here you may specify which of the database connections below you wish
| to use as your default connection for all database work. Of course
| you may use many connections at once using the Database library.
|
    */

'default' => env('DB_CONNECTION', 'mongodb'),
````

- Each model must extend from `\MongoDB\Laravel\Eloquent\Model` class, like this:
````php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends \MongoDB\Laravel\Eloquent\Model
{
    use HasFactory;
    protected $fillable = ['title'];
    protected $collection = 'name'; // table name
}
````

> Note that when storing new data, Laravel will automatically create the collection in the MongoDB database for you. By
> default, the collection name is the plural of the model used (“posts” in this case). However, you can override that by
> setting a collection property on the model like this `protected $collection = 'blog_posts';`

- To add new document
````php
Route::get('test', function () {
   $user =  \App\Models\User::create([
                    'name' => "Ahmed"
                ]);
});
````


- To search for a document
````php
Route::get('test', function () {
   $user = \App\Models\User::findOrFail('651bb67057dd7c9af3077352');
});
````
> `651bb67057dd7c9af3077352` is the value of `_id`
