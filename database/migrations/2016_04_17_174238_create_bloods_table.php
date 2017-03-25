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
            $table->enum('blood_type', ['A', 'B', 'AB', '0']);
            $table->boolean('rh');
            $table->string('mobile')->unique();
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
