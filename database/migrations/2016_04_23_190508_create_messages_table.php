<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('volunteer_id')->unsigned();
            $table->integer('child_id')->unsigned()->nullable();
            $table->longtext('text');
            $table->integer('answered_by')->unsigned()->nullable();
            $table->datetime('answered_at')->nullable();


            $table->timestamps();

            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->foreign('child_id')->references('id')->on('children');
            $table->foreign('answered_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('messages');
    }
}
