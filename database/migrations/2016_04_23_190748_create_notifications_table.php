<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('desc')->nullable();
            $table->string('icon');
            $table->datetime('done_at')->nullable();
            $table->integer('done_by')->unsigned()->nullable();
            $table->string('link')->nullable();
            $table->integer('faculty_id')->unsigned();

            $table->baseActions();

            $table->foreign('faculty_id')->references('id')->on('faculties');
            $table->foreign('done_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
