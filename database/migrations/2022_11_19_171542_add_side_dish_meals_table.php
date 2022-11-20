<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSideDishMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meals', function (Blueprint $table) {
            $table->string('side_dish')->after('name_ar');
            $table->string('side_dish_ar')->after('side_dish');
            $table->integer('recipe_yields')->after('side_dish_ar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meals', function (Blueprint $table) {
            $table->dropColumn('side_dish');
            $table->dropColumn('side_dish_ar');
            $table->dropColumn('recipe_yields');

        });
    }
}
