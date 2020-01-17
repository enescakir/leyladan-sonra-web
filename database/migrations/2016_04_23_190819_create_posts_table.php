<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('child_id')->unsigned();
            $table->longtext('text')->nullable();
            $table->string('type');
            $table->approval();
            $table->baseActions();
            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
        });

        Schema::create('post_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('ratio');
            $table->bigInteger('post_id')->unsigned();

            $table->baseActions();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_images');
        Schema::dropIfExists('posts');

    }
}
