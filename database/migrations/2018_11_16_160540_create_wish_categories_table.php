<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wish_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('desc')->nullable();
            $table->timestamps();
            BaseActions($table);
            $table->softDeletes();
        });

        Schema::table('children', function (Blueprint $table) {
            $table->integer('wish_category_id')->nullable()->unsigned();
            $table->foreign('wish_category_id')->references('id')->on('wish_categories')->onDelete('set null');;
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
            $table->dropForeign(['wish_category_id']);

            $table->dropColumn('wish_category_id');
        });

        Schema::dropIfExists('wish_categories');
    }
}