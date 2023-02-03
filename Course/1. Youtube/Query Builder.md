- The power of laravel is in its object relational model or isa called eloquent
- eloquent focuses mainly on simplicity, it allows you to interact with database using simple functions
- We will start first with query builder in laravel which is the core of laravel's database functionality
- query build uses method chaining to make it as easy as possible
- Most of laravel's database interaction will be written inside the controller whether it was query builder
- or Eloquent

````php
        // don't forget to add (use Illuminate\Support\Facades\DB;)
        $post = DB::statement('SELECT * FROM posts');// pass your raw query statement
        dd($post); // true
````

- whenever you want to select rows from DB it is better to use the method `select`
  than `statement`

````php
        // returns an array of object of class 'stdClass'
        $post = DB::select('SELECT * FROM posts');// pass your raw query statement
        dd($post); 
        dd($post[0]); // first row 
        //echo "<pre>";
        //var_dump($post);
````

- use binding parameter

````php
        $post = DB::select('SELECT * FROM posts WHERE id = ?', [1]); // pass an array as a second parameter
        echo "<pre>";
        var_dump($post);
````

- you can also name the binding parameter like this

````php
        $post = DB::select('SELECT * FROM posts WHERE id = :id', ['id' => 1]);
        echo "<pre>";
        var_dump($post);
````

- You can insert in the database

````php
        $post = DB::insert('INSERT INTO posts (title,excerpt,body,image_path,is_published,min_to_read) VALUES  (?,?,?,?,?,?)', ['TEST', 'TEST', 'TEST', 'TEST', true, 1]);
        echo "<pre>";
        var_dump($post);  
````

- Update the database

````php
        $post = DB::update('UPDATE posts set title = ? , body = ? WHERE id = ?', ['Updated title', 'Updated Body', 1]);
        echo "<pre>";
        var_dump($post);
````

- Delete from database

````php
        $post = DB::delete('DELETE FROM posts WHERE id = ?', [1]);
        echo "<pre>";
        var_dump($post);
````

- to be able to chain methods you have first to use the method `table()`

````php
        $post = DB::table('posts')->get();
        echo "<pre>";
        dd($post);
````

> returns all the records

- to select only title & body columns from table posts

````php
        $post = DB::table('posts')
            ->select('title , body')
            ->get();
        echo "<pre>";
        dd($post);
````

> It is a good practicing to but the chaining method each in a new line

- use where() method

````php
        $post = DB::table('posts')
            ->where('id','>',50)
            ->get();
        echo "<pre>";
        dd($post);
````

- get record with id = 1

````php
        $post = DB::table('posts')
            ->where('id',1)
            ->get();
        echo "<pre>";
        dd($post);
````

- to get post with id 1 or 2

````php
        $post = DB::table('posts')
            ->where('id', '=', 1)
            ->orWhere('id', '=', 2)
            ->get();
        echo "<pre>";
        dd($post);
````

- to get post with id less than or equal to 50 & is published

````php
        $post = DB::table('posts')
            ->where('id', '<=', 50)
            ->Where('is_published', true)
            ->get();
        echo "<pre>";
        dd($post);
````

- to get post with min_to_read between 2 & 4 (inclusive)

````php
        $post = DB::table('posts')
            ->whereBetween('min_to_read', [2, 4])
            ->get();
        echo "<pre>";
        dd($post);
````

- to get post with min_to_read not between 2 & 4 (inclusive)

````php
        $post = DB::table('posts')
            ->whereNotBetween('min_to_read', [2, 4])
            ->get();
        echo "<pre>";
        dd($post);
````

- get posts with min_to_read equal to 2 or 4 or 6

````php
        $post = DB::table('posts')
            ->wherein('min_to_read', [2, 4, 6])
            ->get();
        echo "<pre>";
        dd($post);
````

- get records with body column equal to null

````php
        $post = DB::table('posts')
            ->whereNull('body')
            ->get();
        echo "<pre>";
        dd($post);
````

- get records with body column not equal to null

````php
        $post = DB::table('posts')
            ->whereNotNull('body')
            ->get();
        echo "<pre>";
        dd($post);
````

- to get distinct min_to_read (i have minutes from 1 to 10)

````php
        $post = DB::table('posts')
            ->select('min_to_read')
            ->distinct()
            ->get();
        echo "<pre>";
        dd($post);
````

> if the method `distinct()` is used without chaining with method `select()`
> it will by default select the primary key column (liks saying `SELECT * FROM`)

- get the posts in descending order (by id)

````php
        $post = DB::table('posts')
            ->orderBy('id', 'desc')
            ->get();
        echo "<pre>";
        dd($post);
````

> By default `orderby()` order in ASC order

- the methods `skip()` & `take()` are used in custom pagination (used in Infinite Scrolling)

````php
        $post = DB::table('posts')
            ->skip(30)
            ->take(5)
            ->get();
        echo "<pre>";
        dd($post);
````

> Now I will first skip the first 30 records then I will take the next 5

- to get records in a random order

````php
        $post = DB::table('posts')
            ->inRandomOrder()
            ->get();
        echo "<pre>";
        dd($post);
````

- to get just one record

````php
        $post = DB::table('posts')
            ->where('min_to_read', '>', '3')
            ->first();
        echo "<pre>";
        dd($post);
````

> it will return the first record that has `min_to_read` > 3 <br>
> `first()` method uses `limit 1`

- to get post with id 100

````php
        $post = DB::table('posts')
            ->find(100);
        echo "<pre>";
        dd($post);
````

> `find(100)` is a combination of `where('id',100)` & `first()`

- get just the body of the post with id 100

````php
        $post = DB::table('posts')
            ->where('id', 100)
            ->value('body');
        echo "<pre>";
        dd($post);
````

or

````php
        $post = DB::table('posts')
            ->select('body')
            ->find(100);
        echo "<pre>";
        dd($post);
````

- count the number of records

````php
        $post = DB::table('posts')
            ->count();
        echo "<pre>";
        dd($post);
````

- count the posts that are not published

````php
        $post = DB::table('posts')
            ->where('is_published', false)
            ->count();
        echo "<pre>";
        dd($post);
````

- get min/max/sum/avg value of a column

````php
        $post = DB::table('posts')
            ->sum('min_to_read');
            ->avg('min_to_read'); // or
            ->min('min_to_read'); // or
            ->max('min_to_read'); // or
        echo "<pre>";
        dd($post);
````