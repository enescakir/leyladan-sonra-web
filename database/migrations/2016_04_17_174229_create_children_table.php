<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('faculty_id')->unsigned();
            $table->string('department');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('diagnosis');
            $table->text('diagnosis_desc');
            $table->string('taken_treatment')->nullable();
            $table->string('child_state')->nullable();
            $table->string('child_state_desc')->nullable();
            $table->enum('gender', ['Kız', 'Erkek'])->nullable();
            $table->date('meeting_day');
            $table->date('birthday');
            $table->string('wish');
            $table->string('g_first_name');
            $table->string('g_last_name');
            $table->string('g_mobile')->nullable();
            $table->string('g_email')->nullable();
            $table->string('province');
            $table->string('city');
            $table->text('address');
            $table->text('extra_info')->nullable();
            $table->integer('volunteer_id')->unsigned()->nullable();
            $table->string('verification_doc')->nullable();
            $table->enum('gift_state', ['Bekleniyor', 'Yolda', 'Bize Ulaştı', 'Teslim Edildi'])->default('Bekleniyor');
            $table->boolean('on_hospital')->nullable();
            $table->date('until');
            $table->string('slug');

            $table->baseActions();

            $table->foreign('faculty_id')->references('id')->on('faculties');
            $table->foreign('volunteer_id')->references('id')->on('volunteers')->onDelete('set null');
        });

        Schema::create('child_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('child_id')->unsigned();
            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('child_user');
        Schema::dropIfExists('children');
    }
}
