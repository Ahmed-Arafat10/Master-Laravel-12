<?php

# one of the most important feature introduced by laravel  is to control the database without going to GUI phpmyadmin
# you can create/drop/edit tables using `Database Migration` feature
# all you have to do is to create database in cmd using mysql
# $ D:\xampp\mysql\bin\mysql -uroot -p
# then type following command
# $ create database new_cms
# so, you only need cmd to create the database, other operations will be done using laravel database migration
# go to `.env` file, this file contains all sensitive information that is hidden by server
# all variables in this file are called environment variables
# in this file just edit part related to database configuration
/*
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel --> change this
DB_USERNAME=root
DB_PASSWORD=
 */

# all database migrations in laravel exist in `database` > `migrations` folder
# when you type
# $ php artisan migrate
# laravel will execute all functions in each migration file in this directory
# you can see also that each file in `migrations` folder is responsible for all operations you want for ONE table
# this means that if you have 5 tables, then you will create 5 migration files in this directory, each is responsible for all operations needed for that table
# also you can type following command in terminal to print all configuration information of your project
# $ php artisan about

# you can see in all databases supported in `config` > `database.php` file

# if you observed the `create_user_table.php` file

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    // the function that create the table
    public function up()
    {
        // from schema class access create() static function that takes name of new table as first parameter
        // and has a closure function that pass an object of `Blueprint` class as a parameter
        // table object represents the table in mysql itself
        Schema::create('users', function (Blueprint $table) {
            $table->id();//Create a new auto-incrementing big integer (8-byte) column on the table.
            $table->string('name',);// create a column with data type string with default size 255
            $table->string('address', 50); // create a column with data type string with a specific size
            $table->string('email')->unique();// make column unique
            $table->timestamp('email_verified_at')->nullable(); // make it allow NULL values
            $table->string('password');
            $table->rememberToken();
            $table->timestamps(); // creates [created_at/updated_at] columns automatically
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};


