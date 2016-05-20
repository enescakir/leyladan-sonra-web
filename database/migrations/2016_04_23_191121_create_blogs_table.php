<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->longtext('text')->nullable();
            $table->string('thumb')->nullable();
            $table->integer('author_id')->unsigned()->nullable();
            $table->string('slug');
            $table->string('type');
            $table->string('link')->nullable();

            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');

        });

        Schema::create('blog_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->text('desc')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

        });


        Schema::create('blog_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('blog_id')->unsigned();
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('cascade');

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
        Schema::drop('blog_category');
        Schema::drop('blogs');
        Schema::drop('blog_categories');
    }
}
