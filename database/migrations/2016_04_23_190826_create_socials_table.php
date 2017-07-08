<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('socials', function (Blueprint $table) {
             $table->increments('id');
             $table->integer('child_id')->unsigned()->nullable();

             $table->longtext('facebook_text');
             $table->integer('facebook_by')->unsigned()->nullable();
             $table->dateTime('facebook_at')->nullable();

             $table->text('twitter_text');
             $table->integer('twitter_by')->unsigned()->nullable();
             $table->dateTime('twitter_at')->nullable();

             $table->longtext('instagram_text');
             $table->integer('instagram_by')->unsigned()->nullable();
             $table->dateTime('instagram_at')->nullable();

             $table->string('link')->nullable();

             $table->timestamps();
             BaseActions($table);
             $table->softDeletes();

             $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
             $table->foreign('facebook_by')->references('id')->on('users')->onDelete('set null');
             $table->foreign('twitter_by')->references('id')->on('users')->onDelete('set null');
             $table->foreign('instagram_by')->references('id')->on('users')->onDelete('set null');
         });

        Schema::create('social_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('social_id')->unsigned();
            $table->timestamps();
            BaseActions($table);
            $table->softDeletes();

            $table->foreign('social_id')->references('id')->on('socials')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_images');
        Schema::dropIfExists('socials');
    }
}
