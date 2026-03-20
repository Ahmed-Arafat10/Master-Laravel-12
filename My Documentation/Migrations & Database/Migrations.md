- To check if a table already exists (to prevent error when executing `php artisan serve`), as it executes the commands again
````php
if (!Schema::hasTable('admin'))
````


- To check if one column already exists in a table
````php
if(!Schema::hasColumn('meetings','password'))
````
> Pass table name then column name


- To check if some columns already exist in a table
````php
if (!Schema::hasColumns('attendance', ['Date', 'IP_Address']))
````
> Pass table name then column names in an array


- Create a column then make it `FK`
````php
$table->foreignId('blog_cat_id')
                    ->constrained('id')
                    ->onDelete('cascade');
````

- make a column required
````php		
$table->string('title')->required();
````