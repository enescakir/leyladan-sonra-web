<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('message');
            $table->dateTime('expected_at');
            $table->dateTime('sent_at')->nullable();

            $table->baseActions();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_notifications');
    }
}
