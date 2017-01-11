<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBloodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['Bay', 'Bayan']);
            $table->enum('blood_type', ['A', 'B', 'AB', '0']);
            $table->boolean('rh');
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->date('birthday')->nullable();
            $table->string('mobile')->unique();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->timestamps();
            BaseActions($table);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bloods');
    }
}
