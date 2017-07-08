<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->dateTime('last_login')->nullable();
            $table->integer('faculty_id')->unsigned();
            $table->enum('gender', ['Kadın', 'Erkek'])->nullable();
            $table->date('birthday');
            $table->string('mobile',10);
            $table->string('year');
            $table->string('title');
            $table->dateTime('left_at')->nullable();
            $table->dateTime('graduated_at')->nullable();
            $table->string('email_token')->nullable();
            $table->string('profile_photo')->default('default');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            BaseActions($table);
            Approval($table);
            $table->foreign('faculty_id')->references('id')->on('faculties');
        });


        Schema::table('faculties', function (Blueprint $table) {
            BaseActions($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
