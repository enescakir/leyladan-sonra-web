<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name');
            $table->string('slug');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('address')->nullable();
            $table->string('city');
            $table->string('code')->nullable();
            $table->date('started_at')->nullable();
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
        Schema::drop('faculties');
    }
}
