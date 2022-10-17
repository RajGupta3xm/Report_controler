<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupUnitDislikeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dislike_items', function (Blueprint $table) {
            $table->string('group_id')->after('id')->nullable();
            $table->string('unit_id')->after('category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dislike_items', function (Blueprint $table) {
            $table->dropColumn('group_id');
            $table->dropColumn('unit_id');
        });
    }
}
