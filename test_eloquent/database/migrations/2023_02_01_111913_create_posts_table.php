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
                'tittle' => 'post one',
                'excerpt' => 'summary of post one',
                'body' => 'body of post one',
                'image_path ' => 'Empty',
                'is_published' => false,
                'min_to_read' => 2
         */
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('excerpt');
            $table->string('body');
            $table->integer('min_to_read');
            $table->string('image_path');
            $table->tinyInteger('is_published');
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
