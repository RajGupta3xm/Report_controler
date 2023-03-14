<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDietPlanTypeCalorieMinMaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diet_plan_type_calorie_min_max', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('diet_plan_type_id');
            $table->string('meal_calorie');
            $table->string('protein_min');
            $table->string('protein_max');
            $table->string('carbs_min');
            $table->string('carbs_max');
            $table->string('fat_min');
            $table->string('fat_max');
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
        Schema::dropIfExists('diet_plan_type_calorie_min_max');
    }
}
