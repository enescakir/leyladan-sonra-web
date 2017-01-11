<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_samples', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->longtext('text');
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
        Schema::drop('email_samples');
    }
}
