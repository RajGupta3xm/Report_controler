<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealMacroNutrientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_macro_nutrients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('meal_id');
            $table->string('user_calorie');
            $table->string('size_pcs');
            $table->string('recipe_yields');
            $table->string('meal_calorie');
            $table->string('protein');
            $table->string('carbs');
            $table->string('fat');
            $table->enum('status',['active','inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_macro_nutrients');
    }
}
