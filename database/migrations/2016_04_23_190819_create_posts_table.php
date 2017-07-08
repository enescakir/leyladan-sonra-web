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
            $table->increments('id');
            $table->integer('child_id')->unsigned();
            $table->longtext('text')->nullable();
            $table->string('type');
            $table->timestamps();
            BaseActions($table);
            Approval($table);
            $table->softDeletes();
            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
        });

        Schema::create('post_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('ratio');
            $table->integer('post_id')->unsigned();
            $table->timestamps();
            BaseActions($table);
            $table->softDeletes();

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
