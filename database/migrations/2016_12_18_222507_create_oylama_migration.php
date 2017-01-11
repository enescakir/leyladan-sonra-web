<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOylamaMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oylar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('used_by')->unsigned();
            $table->string('faculty_name');
            $table->boolean('first');
            $table->boolean('second');
            $table->boolean('third');
            $table->dateTime('created_at');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('oylar');
    }
}
