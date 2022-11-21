<?php

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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
};
