- Add in `comopser.json` in `require`

````php
    "require": {
        "mongodb/laravel-mongodb": "dev",
    },
````

> Then run `composer install`

- You will also need to ensure that the mongodb extension is enabled in your php.ini file. The location of your php.ini
  file will vary depending on your operating system. Add the following line to your php.ini file

````php
extension="mongodb.so"
````

### Configuring Your Laravel Project to Use MongoDB

#### Configure MongoDB Database

- In order for Laravel to communicate with your MongoDB database, you will need to add your database connection
  information to the `config\database.php` file under the “connections” object in your Laravel project as shown in this
  example:

````php
'connections' => [
  'mongodb' => [
        'driver' => 'mongodb',
        'dsn' => env('DB_URI', 'mongodb+srv://username:password@<atlas-cluster-uri>/myappdb?retryWrites=true&w=majority'),
        'database' => 'myappdb',
],
````

> Make sure to include the correct authentication information.

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

- for MongoDB, we want to extend the MongoDB Eloquent model, so we want to edit App/Models/Post.php. Our Post model
  ought to look like this:

````php
namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Post extends Model
{
   protected $connection = 'mongodb';

}
````

> Note that when storing new data, Laravel will automatically create the collection in the MongoDB database for you. By
> default, the collection name is the plural of the model used (“posts” in this case). However, you can override that by
> setting a collection property on the model like this `protected $collection = 'blog_posts';`