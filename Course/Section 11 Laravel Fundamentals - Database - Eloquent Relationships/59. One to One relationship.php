<?php

/*
- in this section we will use eloquent to deal with relations between tables
- as we know each user can create a post, it should be a one-to-many relationship (each user can post more than one post)
- but we will assume  in this video that it is one-to-one relationship
- so, first we have to create a new column in `posts` table called `User_ID` this is he foreign key column
- as we already have a `posts` table, then we will create a new migration file to add new column
$ php artisan make:migration create_foriegn_key_post_table --table=posts
- then in it we will type
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('User_ID')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('User_ID');
        });
    }
};

/*
- then we will execute new migration file to create new column
$ php artisan migrate
- Now all we want to do is to create a function in USER model class (not pots class) as its Primary Key is used as a foreign key in `posts` table
- this function will return hasOne() -> first parameter takes path of table that contains FK which is `posts` table
- the second one is the name of FK column, by default it is like name of current model class (in lowercase) + '_id' so by default it assume that
column name is `user_id` if it really is then don't add second parameter, the third paramter is the name of PK in current table, Laravel assume tjhat default name is `id`
if so then don't write the third parameter otherwise type its name
- in below code I typed all parameters to get familiar with it
*/
function post1()
{
    //return $this->hasOne('App\Models\Post', 'User_ID', 'id');
}

/*
- finally we will create a route
*/

// One-to-One relationship
Route::get('/user/{id}/posts', function ($id) {
    // post1() is the function we wrote in User Model Class
    ### In Laravel we can access methods as properties [no need for () ]
    return User::find($id)->post1;
    //return User::find($id)->post1->content;
});

# Note: the output will be just ONE RECORD as it is 1to1 relationship