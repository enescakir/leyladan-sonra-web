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
            $table->integer('approved_by')->unsigned()->nullable();
            $table->date('approved_at')->nullable();
            $table->longtext('text')->nullable();
            $table->string('type');
            $table->timestamps();
            BaseActions($table);
            $table->softDeletes();
            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
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
        Schema::drop('post_images');
        Schema::drop('posts');

    }
}
