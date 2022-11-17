<?php
# in this video we will learn how to add a new column to a table without dropping the whole table
# this is not feasible as this table may contain records which will be deleted
# to do this type:
# $ php artisan make:migration add_is_admin_column --table="posts"
# note: you can type --table=posts without quotes

# in `add_is_admin_column.php` file the following code will be created

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // add a new column called `is_admin`
            //$table->integer('is_admin')->unsigned();// unsigned means positive numbers only as you already know
            $table->tinyInteger('is_admin')->default('0');
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
            $table->dropColumn('is_admin');
        });
    }
};

/*
    - then type following command
    $ php artisan migrate
    - as we said before previous command execute all latest migration files
    - again to undo last migration command type
    $ php artisan migrate:rollback
 */