- create a model + migration

````php
php artisan make:model Phone -m
````

- create a migration

````php
php artisan make:migration drop_user_table
````

````php
public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
````

````php
public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            // as this column will be the foreign key, it must have the same data type as `id` column in users table
            // so you have to make it bigInteger() & unsigned()
            $table->bigInteger('user_id')->unsigned();
            $table->string('phone');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade'); // means if a record is deleted from user table
                // it then will delete all records having the id of this record in this table (phone table)
           
        });
    }
````

- user model class

````php
  public function phonehhh()
    {
        // by default eloquent assumes that name of  the FK in phone table
        // is name of the current model (user) + '_id' = user_id
        // & the name of id column of the current model is 'id'
        // to change this convention add the FK name as second parameter
        // and the PK name as the third parameter 
        return $this->hasOne(Phone::class);
    }
````

- phone model class

````php
public function user()
    {
        // eloquent will assume that the name of the FK in this table will be the name of this
        // method + '_id' so the result will be = 'user_id'
        return $this->belongsTo(\App\Models\User::class);
    }

    public function userhhh()
    {
        // as the name of this function will generate a 'userhhh_id' FK column name, we have to specify
        // FK name as the second parameter
        // & the third parameter is the name of PK coumn in 'user' table (by default eloquen assumes it is `id`)
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
````

````php
use \App\Models\User;

Route::get('/createuser', function () {
    User::create([
        'name' => 'Ahmed',
        'email' => 'ahmed@gmail.com',
        'password' => bcrypt('123')
    ]);
});

Route::get('/onetoone/{userid}', function ($userid) {
    $user = User::findOrFail($userid);
    //dd($user);
    var_dump($user->phonehhh); // returns an object (access any attribute using ->name for example
});
Route::get('/onetoone_phone/{phoneid}', function ($phoneid) {
    $phone = \App\Models\Phone::findOrFail($phoneid);
    //dd($phone);
    var_dump($phone->user); // returns an object
});
````