<?php

# in this video we will create our new table
# first we will create a new file in `migrations` folder, in laravel naming of migration file should be like this `x_y_z.php` snake style (a good practicing)
# to make creating a file automatic you can type following command
# $ php artisan make:migration FileName --create="TableName"
#so we can then type
# $ php artisan make:migration create_posts_table --create="posts"
#output in thr file will be

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
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('body');
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
        Schema::dropIfExists('posts');
    }
};

# to make the new migrate file execute type
# $ php artisan migrate

# to undo last migration type
# $ php artisan migrate:rollback