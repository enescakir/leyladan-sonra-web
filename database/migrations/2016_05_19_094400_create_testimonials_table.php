<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longtext('text');
            $table->string('email')->nullable();
            $table->string('via');
            $table->integer('priority')->unsigned()->default(1);
            $table->integer('approved_by')->unsigned()->nullable();
            $table->date('approved_at')->nullable();

            $table->timestamps();
            BaseActions($table);
            $table->softDeletes();

            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('testimonials');
    }
}
