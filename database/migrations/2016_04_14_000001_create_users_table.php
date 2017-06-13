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
            $table->string('email_token')->nullable();
            $table->string('profile_photo')->default('default');
            $table->datetime('activated_at')->nullable();
            $table->integer('activated_by')->unsigned()->nullable();
            $table->rememberToken();

            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('faculty_id')->references('id')->on('faculties');
            $table->foreign('activated_by')->references('id')->on('users');

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
        Schema::drop('users');
    }
}
