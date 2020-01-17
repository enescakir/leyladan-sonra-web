<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStopToFaculty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->dateTime('stopped_at')->nullable();
            $table->bigInteger('stopped_by')->unsigned()->nullable();
            $table->foreign('stopped_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->dropForeign(['stopped_by']);
            $table->dropColumn('stopped_at');
            $table->dropColumn('stopped_by');
        });
    }
}
