<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFeedStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feeds', function (Blueprint $table) {
            $table->string('title')->nullable()->change();

            $table->renameColumn('title', 'role');
            $table->renameColumn('icon', 'type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feeds', function (Blueprint $table) {
            $table->string('role')->nullable(false)->change();

            $table->renameColumn('role', 'title');
            $table->renameColumn('type', 'icon');

        });
    }
}
