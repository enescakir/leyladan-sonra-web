<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostIdsToChild extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('children', function (Blueprint $table) {
            $table->bigInteger('meeting_post_id')->nullable()->unsigned();
            $table->foreign('meeting_post_id')->references('id')->on('posts');
            $table->bigInteger('delivery_post_id')->nullable()->unsigned();
            $table->foreign('delivery_post_id')->references('id')->on('posts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('children', function (Blueprint $table) {
            $table->dropForeign(['meeting_post_id']);
            $table->dropForeign(['delivery_post_id']);

            $table->dropColumn('meeting_post_id');
            $table->dropColumn('delivery_post_id');
        });
    }
}