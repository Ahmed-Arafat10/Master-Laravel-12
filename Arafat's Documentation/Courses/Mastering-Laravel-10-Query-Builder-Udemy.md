#### 9. Running migrations & different options

- show `MySQL` connection
````php
php artisan db:show
````

- show `MySQL` commands for creating tables (must use before actual migrating your tables)

````php
php artisan migrate --pretend
````

| Migration File                                        | MySQL Command                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
|-------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 2014_10_12_100000_create_password_reset_tokens_table  | create table `password_reset_tokens` (`email` varchar(255) not null, `token` varchar(255) not null, `created_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci' <br> alter table `password_reset_tokens` add primary key (`email`)                                                                                                                                                                                                                                                                                                                                                                                                                                             |
| 2019_08_19_000000_create_failed_jobs_table            | create table `failed_jobs` (`id` bigint unsigned not null auto_increment primary key, `uuid` varchar(255) not null, `connection` text not null, `queue` text not null, `payload` longtext not null, `exception` longtext not null, `failed_at` timestamp not null default CURRENT_TIMESTAMP) default character set utf8mb4 collate 'utf8mb4_unicode_ci' <br> alter table `failed_jobs` add unique `failed_jobs_uuid_unique`(`uuid`)                                                                                                                                                                                                                                                                        |
| 2019_12_14_000001_create_personal_access_tokens_table | create table `personal_access_tokens` (`id` bigint unsigned not null auto_increment primary key, `tokenable_type` varchar(255) not null, `tokenable_id` bigint unsigned not null, `name` varchar(255) not null, `token` varchar(64) not null, `abilities` text null, `last_used_at` timestamp null, `expires_at` timestamp null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci' <br> alter table `personal_access_tokens` add index `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) <br> alter table `personal_access_tokens` add unique `personal_access_tokens_token_unique`(`token`) |
| 2023_10_08_063802_create_posts_table                  | create table `posts` (`id` bigint unsigned not null auto_increment primary key, `title` varchar(255) not null, `slug` varchar(255) not null, `excerpt` text not null comment 'Summary of a post', `description` longtext not null, `is_published` tinyint(1) not null default '0', `min_to_read` int not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci' <br> alter table `posts` add unique `posts_title_unique`(`title`) <br> alter table `posts` add unique `posts_slug_unique`(`slug`)                                                                                                                                      |
> It will result in error if there is an error in your migration

- force migrations even if it is already done

````php
php artisan migrate --force
````

> All tables Data will be deleted be careful

- this command will roll back just last 2 migrations files (depending on date of course)

````php
php artisan migrate:rollback --step=2
````

> INFO Rolling back migrations. <br>
>2023_10_08_063802_create_posts_table | 10ms DONE <br>
>2019_12_14_000001_create_personal_access_tokens_table | 4ms DONE <br>

````php
php artisan migrate:refresh
````

> it is combination of `php artisan migrate:reset` then `php artisan migrate`

- you can use it with `--step` flag

````php
php artisan migrate:refresh --step=2
````

````php
php artisan migrate:fresh
````

> it doesn't execute `down() method, it first delete all tables, then execute `up()` method for each migration


#### must have `mysqldump` installed to do the following

- to take all migration files and then create a Mysql file (`.sql`) from then

````php
php artisan schema:dump
````

> original migrations will not be effected

````php
php artisan schema:dump --prune
````

<hr>
<hr>

````php
php artisan db:seed --class=PostSeeder
````
> when we use `php artisan db:seed` it executes `DatabaseSeeder.php`, but if I want to execute just one seeder use above method


````php
php artisan migrate --seed
````

````php
php artisan migrate:refresh --seed
````

show columns and structure of a table from CLI
````php
php artisan db:table posts
````
````
posts ...........
Columns .... 10
Size .... 0.05MiB
Column ..... Type
id autoincrement, bigint, unsigned .. bigint
title string ..... string
slug string ...... string
excerpt text ....... text
content text ....... text
is_published boolean .... boolean
min_to_read integer .... integer
created_at datetime, nullable ..... datetime
updated_at datetime, nullable ..... datetime
deleted_at datetime, nullable ..... datetime
Index 
posts_title_unique title ... unique
posts_slug_unique slug ... unique
posts_user_id_foreign user_id ...
PRIMARY id ... unique, primary
Foreign Key ... On Update / On Delete  
posts_user_id_foreign user_id references id on users ... / cascade
````

<hr>

````php
  $posts = DB::table('posts')
            ->select('excerpt', 'content as Description') # new: as alias
            ->get();
        dd($posts);
````


````php
        $posts = DB::table('posts')
            ->select('is_published')
            ->distinct()
            ->get();
        dd($posts);
````

````php
 $posts = DB::table('posts')
            ->select('excerpt');
        $addedPosts = $posts->addSelect('content')->get();
        dd($addedPosts);
````

# Section #4: Mastering the Query Builder [PART 1]

video #22
````php
$table->id()->startingValue(100);
````

another way to create a primary key
````php
$table->bigIncrements('user_id');
````


````php
    public function index()
    {
        $res = DB::table('posts')
            ->select('is_published');
        $res = $res->addSelect('title')->get(); // add COLUMN to be selected with `is_published`
        dump($res);
    }
````

- get first element in collection using `first()`, then access content attribute
````php
        $res = DB::table('posts')
            ->select()
            ->where('id', 100)
            ->first();
        dd($res->content);
````

- you can use `value(col)` method as `first()` but with the column you want to get
````php
 $res = DB::table('posts')
            ->select()
            ->where('id', 100)
            ->value('content');
        dd($res);
````

- use `find()` instead of `where()` when you want to find a specific PK 
````php
 $posts = DB::table('posts')
 ->find(99);
````

- to retrieve a collection ( as `get()`) then just get `content` of each array with key `id` refers to it
````php
  $res = DB::table('posts')
            ->pluck('content','id');
        dd($res);
````
> it is like `value()` but with collections


- insert multiple records
````php
    public function index()
    {
        $res = DB::table('posts')
            ->insert([
                'user_id' => 1,
                'title' => "my new title",
                'slug' => "my new slug",
                'excerpt' => "exc",
                'description' => "desc",
                'is_published' => true,
                'min_to_read' => 2,
            ]);
        // or insert multiple records
        $res = DB::table('posts')
            ->insert([
                [
                    'user_id' => 1,
                    'title' => "my new title",
                    'slug' => "my new slug",
                    'excerpt' => "exc",
                    'description' => "desc",
                    'is_published' => true,
                    'min_to_read' => 2,
                ],
                [
                    'user_id' => 1,
                    'title' => "my new title",
                    'slug' => "my new slug",
                    'excerpt' => "exc",
                    'description' => "desc",
                    'is_published' => true,
                    'min_to_read' => 2,
                ]
            ]);
        dd($res);
    }
````

- if there is a conflict in PK or any unique attribute while inserting use `insertOrIgnore()`
````php
   public function index()
    {
        $res = DB::table('posts')
            ->insertOrIgnore([
                'user_id' => 1,
                'title' => "my new title",
                'slug' => "my new slug",
                'excerpt' => "exc",
                'description' => "desc",
                'is_published' => true,
                'min_to_read' => 2,
            ]);
        dd($res);
    }
````

#### `upsert()`
- used to update a record if second parameters with specified values otherwise insert it as a new record
- The upsert method will insert records that do not exist and update the records that already exist with new values that you may specify. The method's first argument consists of the values to insert or update, while the second argument lists the column(s) that uniquely identify records within the associated table. The method's third and final argument is an array of columns that should be updated if a matching record already exists in the database:
````php
   public function index()
    {
        $res = DB::table('posts')
            ->upsert([
                'user_id' => 1,
                'title' => "my new title",
                'slug' => "my new slug",
                'excerpt' => "exc",
                'description' => "desc",
                'is_published' => true,
                'min_to_read' => 2,
            ],['title','slug']);
        dd($res);
    }
````



#### `insertGetId()`
- If the table has an auto-incrementing id, use the insertGetId method to insert a record and then retrieve the ID:
````php
$id = DB::table('users')->insertGetId(
    ['email' => 'john@example.com', 'votes' => 0]
);
````


#### `Increment()` & `Decrement()`
- The query builder also provides convenient methods for incrementing or decrementing the value of a given column. Both of these methods accept at least one argument: the column to modify. A second argument may be provided to specify the amount by which the column should be incremented or decremented:
````php
DB::table('users')->increment('votes');
 
DB::table('users')->increment('votes', 5);
 
DB::table('users')->decrement('votes');
 
DB::table('users')->decrement('votes', 5);
````
> you can use it with `where()` to updated specific records

In addition, you may increment or decrement multiple columns at once using the incrementEach and decrementEach methods:
````php
DB::table('users')->incrementEach([
    'votes' => 5,
    'balance' => 100,
]);
````


#### `updateOrInsert()`
Sometimes you may want to update an existing record in the database or create it if no matching record exists. In this scenario, the updateOrInsert method may be used. The updateOrInsert method accepts two arguments: an array of conditions by which to find the record, and an array of column and value pairs indicating the columns to be updated.

The `updateOrInsert` method will attempt to locate a matching database record using the first argument's column and value pairs. If the record exists, it will be updated with the values in the second argument. If the record can not be found, a new record will be inserted with the merged attributes of both arguments:
````php
DB::table('users')
    ->updateOrInsert(
        ['email' => 'john@example.com', 'name' => 'John'],
        ['votes' => '2']
    );
````
> Note: it executes two sql queries as it first select with first parameter and if exists then it will update otherwise it will insert ,so it performs 2 queries
> <br> another method called `upsert()` is better when dealing with many records


#### `truncate()`
If you wish to truncate an entire table, which will remove all records from the table and reset the auto-incrementing ID to zero, you may use the `truncate` method:
````php
DB::table('users')->truncate();
````

#### `whereNot()`
The `whereNot` and `orWhereNot` methods may be used to negate a given group of query constraints. For example, the following query excludes products that are on clearance or which have a price that is less than ten:
````php
$products = DB::table('products')
                ->whereNot(function (Builder $query) {
                    $query->where('clearance', true)
                          ->orWhere('price', '<', 10);
                })
                ->get();
````


#### `exists()`
Instead of using the `count` method to determine if any records exist that match your query's constraints, you may use the `exists` and `doesntExist` methods:
````php
if (DB::table('orders')->where('finalized', 1)->exists()) {
    // ...
}
 
if (DB::table('orders')->where('finalized', 1)->doesntExist()) {
    // ...
}
````

#### `whereBetween()` / `orWhereBetween()` / `whereNotBetween()` / `orWhereNotBetween()`
The `whereBetween` method verifies that a column's value is between two values:
````php
$users = DB::table('users')
           ->whereBetween('votes', [1, 100])
           ->get();
````

The `whereNotBetween` method verifies that a column's value lies outside of two values:
````php
$users = DB::table('users')
                    ->whereNotBetween('votes', [1, 100])
                    ->get();
````


# Section #5: Mastering the Query Builder [PART 2]

#### `Transactions()`
You may use the transaction method provided by the DB facade to run a set of operations within a database transaction. If an exception is thrown within the transaction closure, the transaction will automatically be rolled back and the exception is re-thrown. If the closure executes successfully, the transaction will automatically be committed. You don't need to worry about manually rolling back or committing while using the transaction method:
````php
use Illuminate\Support\Facades\DB;
 
DB::transaction(function () {
    DB::update('update users set votes = 1');
 
    DB::delete('delete from posts');
});
````

#### Handling Deadlocks
The transaction method accepts an optional second argument which defines the number of times a transaction should be retried when a deadlock occurs. Once these attempts have been exhausted, an exception will be thrown:
````php
use Illuminate\Support\Facades\DB;
 
DB::transaction(function () {
    DB::update('update users set votes = 1');
 
    DB::delete('delete from posts');
}, 5);
````


#### Pessimistic Locking
The query builder also includes a few functions to help you achieve "pessimistic locking" when executing your select statements. To execute a statement with a "shared lock", you may call the sharedLock method. A shared lock prevents the selected rows from being modified until your transaction is committed:
````php
DB::table('users')
        ->where('votes', '>', 100)
        ->sharedLock()
        ->get();
````
Alternatively, you may use the lockForUpdate method. A "for update" lock prevents the selected records from being modified or from being selected with another shared lock:
````php
DB::table('users')
        ->where('votes', '>', 100)
        ->lockForUpdate()
        ->get();
````


### `chunk()`
If you need to work with thousands of database records, consider using the chunk method provided by the DB facade. This method retrieves a small chunk of results at a time and feeds each chunk into a closure for processing. For example, let's retrieve the entire users table in chunks of 100 records at a time:
````php
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

DB::table('users')->orderBy('id')->chunk(100, function (Collection $users) {
foreach ($users as $user) {
// ...
}
});
````

You may stop further chunks from being processed by returning false from the closure:
````php
DB::table('users')->orderBy('id')->chunk(100, function (Collection $users) {
// Process the records...

    return false;
});
````

If you are updating database records while chunking results, your chunk results could change in unexpected ways. If you plan to update the retrieved records while chunking, it is always best to use the chunkById method instead. This method will automatically paginate the results based on the record's primary key:
````php
DB::table('users')->where('active', false)
    ->chunkById(100, function (Collection $users) {
        foreach ($users as $user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['active' => true]);
        }
    });
````

#### `lazy()`
The lazy method works similarly to the chunk method in the sense that it executes the query in chunks. However, instead of passing each chunk into a callback, the lazy() method returns a LazyCollection, which lets you interact with the results as a single stream:
````php
use Illuminate\Support\Facades\DB;
 
DB::table('users')->orderBy('id')->lazy()->each(function (object $user) {
    // ...
});
````
Once again, if you plan to update the retrieved records while iterating over them, it is best to use the lazyById or lazyByIdDesc methods instead. These methods will automatically paginate the results based on the record's primary key:
````php
DB::table('users')->where('active', false)
    ->lazyById()->each(function (object $user) {
        DB::table('users')
            ->where('id', $user->id)
            ->update(['active' => true]);
    });
````

#### Raw Expressions
Sometimes you may need to insert an arbitrary string into a query. To create a raw string expression, you may use the raw method provided by the DB facade:
````php
$users = DB::table('users')
->select(DB::raw('count(*) as user_count, status'))
->where('status', '<>', 1)
->groupBy('status')
->get();
````
Raw statements will be injected into the query as strings, so you should be extremely careful to avoid creating SQL injection vulnerabilities.

Raw Methods
Instead of using the DB::raw method, you may also use the following methods to insert a raw expression into various parts of your query. Remember, Laravel can not guarantee that any query using raw expressions is protected against SQL injection vulnerabilities.

##### selectRaw
The selectRaw method can be used in place of addSelect(DB::raw(/* ... */)). This method accepts an optional array of bindings as its second argument:
````php
$orders = DB::table('orders')
->selectRaw('price * ? as price_with_tax', [1.0825])
->get();
````

##### whereRaw / orWhereRaw
The whereRaw and orWhereRaw methods can be used to inject a raw "where" clause into your query. These methods accept an optional array of bindings as their second argument:

````php
$orders = DB::table('orders')
->whereRaw('price > IF(state = "TX", ?, 100)', [200])
->get();
````


#### havingRaw / orHavingRaw
The havingRaw and orHavingRaw methods may be used to provide a raw string as the value of the "having" clause. These methods accept an optional array of bindings as their second argument:
````php
$orders = DB::table('orders')
->select('department', DB::raw('SUM(price) as total_sales'))
->groupBy('department')
->havingRaw('SUM(price) > ?', [2500])
->get();
````
##### orderByRaw
The orderByRaw method may be used to provide a raw string as the value of the "order by" clause:
````php
$orders = DB::table('orders')
->orderByRaw('updated_at - created_at DESC')
->get();
````

#### groupByRaw
The groupByRaw method may be used to provide a raw string as the value of the group by clause:
````php
$orders = DB::table('orders')
->select('city', 'state')
->groupByRaw('city, state')
->get();
````


## Ordering

#### The orderBy Method
The orderBy method allows you to sort the results of the query by a given column. The first argument accepted by the orderBy method should be the column you wish to sort by, while the second argument determines the direction of the sort and may be either asc or desc:
````php
$users = DB::table('users')
->orderBy('name', 'desc')
->get();
````

To sort by multiple columns, you may simply invoke orderBy as many times as necessary:
````php
$users = DB::table('users')
->orderBy('name', 'desc')
->orderBy('email', 'asc')
->get();
````

#### The latest & oldest Methods
The latest and oldest methods allow you to easily order results by date. By default, the result will be ordered by the table's created_at column. Or, you may pass the column name that you wish to sort by:
````php
$user = DB::table('users')
->latest()
->first();
````

#### Random Ordering
The inRandomOrder method may be used to sort the query results randomly. For example, you may use this method to fetch a random user:
````php
$randomUser = DB::table('users')
->inRandomOrder()
->first();
````

#### Removing Existing Orderings
The reorder method removes all of the "order by" clauses that have previously been applied to the query:
````php
$query = DB::table('users')->orderBy('name');

$unorderedUsers = $query->reorder()->get();
````



You may pass a column and direction when calling the reorder method in order to remove all existing "order by" clauses and apply an entirely new order to the query:
````php
$query = DB::table('users')->orderBy('name');

$usersOrderedByEmail = $query->reorder('email', 'desc')->get();
````

## Full Text Where Clauses
The `whereFullText` and `orWhereFullText` methods may be used to add full text "where" clauses to a query for columns that have full text indexes. These methods will be transformed into the appropriate SQL for the underlying database system by Laravel. For example, a MATCH AGAINST clause will be generated for applications utilizing MySQL:
````php
$users = DB::table('users')
           ->whereFullText('bio', 'web developer')
           ->get();
````

### Available Index Types
Laravel's schema builder blueprint class provides methods for creating each type of index supported by Laravel. Each index method accepts an optional second argument to specify the name of the index. If omitted, the name will be derived from the names of the table and column(s) used for the index, as well as the index type. Each of the available index methods is described in the table below:

| Syntax                                            |                          Description                           |
|---------------------------------------------------|:--------------------------------------------------------------:|
| `$table->primary('id');`                          |                      Adds a primary key.                       |
| `$table->primary(['id', 'parent_id']); `          |                      Adds composite keys.                      |
| `$table->unique('email');`                        |                      Adds a unique index.                      |
| `$table->index('state');`	                        |                         Adds an index.                         |
| `$table->fullText('body');`	                      |           Adds a full text index (MySQL/PostgreSQL).           |
| `$table->fullText('body')->language('english');	` | Adds a full text index of the specified language (PostgreSQL). |
| `$table->spatialIndex('location');`	              |             Adds a spatial index (except SQLite).              |	



### Limit & Offset
The skip & take Methods
You may use the skip and take methods to limit the number of results returned from the query or to skip a given number of results in the query:

````php
````

````php
$users = DB::table('users')->skip(10)->take(5)->get();
````
Alternatively, you may use the limit and offset methods. These methods are functionally equivalent to the take and skip methods, respectively:

````php
$users = DB::table('users')
->offset(10)
->limit(5)
->get();
````


## Conditional Clauses
Sometimes you may want certain query clauses to apply to a query based on another condition. For instance, you may only want to apply a where statement if a given input value is present on the incoming HTTP request. You may accomplish this using the when method:
````php
$role = $request->string('role');

$users = DB::table('users')
->when($role, function (Builder $query, string $role) {
$query->where('role_id', $role);
})
->get();
````
The when method only executes the given closure when the first argument is true. If the first argument is false, the closure will not be executed. So, in the example above, the closure given to the when method will only be invoked if the role field is present on the incoming request and evaluates to true.

You may pass another closure as the third argument to the when method. This closure will only execute if the first argument evaluates as false. To illustrate how this feature may be used, we will use it to configure the default ordering of a query:
````php
$sortByVotes = $request->boolean('sort_by_votes');

$users = DB::table('users')
->when($sortByVotes, function (Builder $query, bool $sortByVotes) {
$query->orderBy('votes');
}, function (Builder $query) {
$query->orderBy('name');
})
->get();
````
