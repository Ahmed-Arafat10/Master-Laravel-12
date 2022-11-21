<?php
# $ php artisan make:model Role -m
# Role migrate file
function up()
{
    Schema::create('roles', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });
}

# $ php artisan make:migrate create_role_user_table --create=role_user

function up2()
{
    /*
       - An important rule that when you create a pivot table resulting from many-to-many relaionship
       - in Laravel naming of this table should be singular name of both tables (users -> user) with
        `_` between tables names as a separator & mostly important is to concat names according to their
        alphabetical order, this means that `role` table must be the first one
        so, result will be `role_user` NOT `user_role`
     */
    Schema::create('role_user', function (Blueprint $table) {
        $table->increments('id');
        // naming of primary key must be in this format, `tableName`+`_id` as Laravel understand that this is the ID of that table
        $table->integer('user_id');
        $table->integer('role_id');
        $table->timestamps();
    });
}

# $ php artisan migrate

# then insert data in both `role` & `role_user` tables

