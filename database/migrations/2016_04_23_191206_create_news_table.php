<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('logo');
            $table->string('category');

            $table->baseActions();

        });

        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('desc');
            $table->string('link');
            $table->bigInteger('channel_id')->unsigned();

            $table->baseActions();

            $table->foreign('channel_id')->references('id')->on('channels');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
        Schema::dropIfExists('channels');
    }
}
